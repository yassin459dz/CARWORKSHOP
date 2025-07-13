<?php

namespace App\Livewire;

use App\Models\Factures;
use App\Models\CaisseHistorique;
use App\Models\Cashbox;
use Livewire\Component;
use Illuminate\Support\Carbon;

class CashboxLedger extends Component
{
    public ?string $searchDateFrom = null;
    public ?string $searchDateTo = null;

    // Balances map
    public array $dailyBalances = [];

    // Selected day details
    public ?string $selectedDate = null;
    public float $startValue = 0;
    public float $inflow = 0;
    public float $outflow = 0;
    public float $total = 0;

    public $facturesOfDay = [];
    public $mouvementsOfDay = [];

    // End value and décalage fields
    public ?string $endEditDate = null;
    public ?float $endValue = null;
    public ?float $actualCashCount = null; // New field for actual cash count
    public ?float $decalage = null;
    public bool $showEndModal = false;
    public ?float $nextStartValue = null;
    public bool   $unlocked        = false;
    public string $enteredPassword = '';

    // Listeners for Alpine.js value changes
    protected $listeners = [
        'actualCashCountUpdated' => 'updateDecalage'

    ];

    protected array $rules = [
        'enteredPassword' => 'required|string'
      ];

      public function unlock()
      {
        $this->validate();

        if (strcasecmp($this->enteredPassword, config('cashbox.password', '')) === 0) {
            session()->put('cashbox_unlocked', true);
            $this->unlocked = true;
            $this->loadBalances();
        } else {
            $this->addError('enteredPassword', 'Incorrect password.');
        }
      }

    public function mount()
    {
                // check session in case they already unlocked
                $this->unlocked = session()->get('cashbox_unlocked', false);

                if ($this->unlocked) {
                    $this->loadBalances();
                }
        // Ensure a cashbox record exists for today
        $today = Carbon::today();
        $this->loadBalances();

        // DEV ONLY: auto-open modal for 26/04/2025
        // if (app()->environment('local')) {
        //     // ISO date string:
        //     $devDate = '2025-04-26';
        //     if (isset($this->dailyBalances[$devDate])) {
        //         $this->view($devDate);
        //     }
        // }
    }
    public function refreshSession()
    {
        session()->forget('cashbox_unlocked');
        $this->unlocked = false;
        $this->enteredPassword = '';
        $this->dailyBalances = [];
    }

    public function loadBalances(): void
    {
        $boxes = Cashbox::orderBy('created_at','desc')->get();

        // Build date→override map
        $overrides = $boxes
            ->pluck('next_start_value','created_at')
            ->mapWithKeys(fn($val,$ts) => [
                Carbon::parse($ts)->toDateString() => $val
            ])
            ->toArray();

        $this->dailyBalances = $boxes
            ->mapWithKeys(function (Cashbox $box) use ($overrides) {
                $date = $box->created_at->toDateString();
                $prev = Carbon::parse($date)->subDay()->toDateString();

                $start = array_key_exists($prev,$overrides) && $overrides[$prev] !== null
                       ? (float)$overrides[$prev]
                       : (float)$box->start_value;

                $in = Factures::whereDate('created_at',$date)->sum('total_amount');
                $cashIn = Factures::whereDate('created_at',$date)->sum('paid_value'); // Add this line
                $mouvements = CaisseHistorique::whereDate('created_at',$date)->get();
                $out = $mouvements->sum('montant');

                $computed = $start + $cashIn - $out; // Change $in to $cashIn
                $running  = $box->end_value !== null ? $box->end_value : $computed;

                return [
                    $date => [
                        'created_at'       => $box->created_at,
                        'start'            => $start,
                        'entree'           => $in,
                        'cash_in'          => $cashIn, // Add this line
                        'sortie'           => $out,
                        'computed'         => $computed,
                        'solde'            => $running,
                        'end_value'        => $running,
                        'manual_end_value' => $box->manual_end_value,
                        'manual_end_set'   => $box->manual_end_set,
                        'updated_at'       => $box->updated_at,
                        'mouvements'       => $mouvements,
                        'decalage'         => $box->decalage,
                    ],
                ];
            })
            ->toArray();
    }


    public function view(string $date): void
    {
        $this->loadBalances();

        $this->selectedDate  = $date;
        $this->startValue    = $this->dailyBalances[$date]['start'];
        $this->inflow        = $this->dailyBalances[$date]['entree'];
        $this->outflow       = $this->dailyBalances[$date]['sortie'];
        $this->total         = $this->startValue + $this->dailyBalances[$date]['cash_in'] - $this->outflow; // Change to use cash_in
        $this->facturesOfDay = Factures::whereDate('created_at', $date)
                                        ->with(['client','car'])
                                        ->get();
        $this->mouvementsOfDay = CaisseHistorique::whereDate('created_at', $date)
                                                 ->get();

        $this->endEditDate     = $date;
        $box = Cashbox::whereDate('created_at', $date)->first();

        // Prefill the two fields:
        $this->actualCashCount = $box && $box->manual_end_set
                              ? $box->manual_end_value
                              : $this->total;

        $this->decalage        = $box?->decalage ?? 0;
        $this->nextStartValue  = $box?->next_start_value ?? $this->actualCashCount;
    }





    public function editEndValue(string $date): void
    {
        $this->endEditDate = $date;
        $cashbox = Cashbox::whereDate('created_at', $date)->first();
        $this->nextStartValue = $cashbox->next_start_value;
        $this->endValue = $cashbox->end_value ?? ($this->dailyBalances[$date]['solde'] ?? 0);
        $this->actualCashCount = $cashbox->manual_end_value ?? $this->endValue;
        $this->decalage = $cashbox->decalage ?? 0;

        $this->showEndModal = true;
    }

    /**
     * Update the décalage value when actual cash count changes
     */
    public function updateDecalage($value = null): void
    {
        if ($value !== null) {
            $this->actualCashCount = (float) $value;
        }

        if ($this->actualCashCount !== null && $this->total !== null) {
            $this->decalage = $this->actualCashCount - $this->total;
        } else {
            $this->decalage = 0;
        }
    }

    /**
     * Save both the actual cash count and the calculated décalage
     */
    public function saveEndValue(): void
    {
        $date     = Carbon::parse($this->endEditDate)->toDateString();
        $todayBox = Cashbox::whereDate('created_at', $date)->first();

        if (! $todayBox) {
            session()->flash('error', "Cashbox not found for {$date}");
            return;
        }

        // Save today's actual count and leftover
        $todayBox->end_value         = $this->actualCashCount;
        $todayBox->manual_end_value  = $this->actualCashCount;
        $todayBox->manual_end_set    = true;
        $todayBox->decalage          = $this->decalage;
        $todayBox->next_start_value  = $this->nextStartValue;
        $todayBox->save();

        // If tomorrow exists, override its start_value immediately
        $tomorrow   = Carbon::parse($date)->addDay()->toDateString();
        $tomorrowBox = Cashbox::whereDate('created_at', $tomorrow)->first();
        if ($tomorrowBox) {
            $tomorrowBox->start_value = $this->nextStartValue;
            $tomorrowBox->save();
        }

        $this->loadBalances();
        session()->flash('message', 'End‐of‐day saved and next‐day start set.');
    }


    public function previousDate(): ?string
    {
        $dates = array_keys($this->dailyBalances);
        sort($dates); // oldest → newest
        $currentIndex = array_search($this->selectedDate, $dates, true);
        return $currentIndex > 0 ? $dates[$currentIndex - 1] : null;
    }

    public function nextDate(): ?string
    {
        $dates = array_keys($this->dailyBalances);
        sort($dates); // oldest → newest
        $currentIndex = array_search($this->selectedDate, $dates, true);
        return $currentIndex < count($dates) - 1
            ? $dates[$currentIndex + 1]
            : null;
    }

    public function goPrevious(): void
    {
        if ($prev = $this->previousDate()) {
            $this->view($prev);
        }
    }

    public function goNext(): void
    {
        if ($next = $this->nextDate()) {
            $this->view($next);
        }
    }

    public function render()
    {
        return view('livewire.cashbox-ledger', [
            'dailyBalances'   => $this->dailyBalances,
            'facturesOfDay'   => $this->facturesOfDay,
            'mouvementsOfDay' => $this->mouvementsOfDay,
        ]);
    }
}