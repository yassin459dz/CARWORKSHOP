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
    

    // Listeners for Alpine.js value changes
    protected $listeners = [
        'actualCashCountUpdated' => 'updateDecalage'
    ];

    public function mount()
    {
        // Ensure a cashbox record exists for today
        $today = Carbon::today();
        $this->loadBalances();

        // DEV ONLY: auto-open modal for 26/04/2025
        if (app()->environment('local')) {
            // ISO date string:
            $devDate = '2025-04-26';
            if (isset($this->dailyBalances[$devDate])) {
                $this->view($devDate);
            }
        }
    }

    public function loadBalances(): void
    {
        // Pull every cashbox and key them by date
        $this->dailyBalances = Cashbox::orderBy('created_at', 'desc')
            ->get()
            ->mapWithKeys(function (Cashbox $box) {
                $date = $box->created_at->toDateString();

                // 1 Total invoices (inflow)
                $in = Factures::whereDate('created_at', $date)
                              ->sum('total_amount');

                // 2 All cash movements (outflow/inflow)
                $mouvements = CaisseHistorique::whereDate('created_at', $date)
                                              ->get();

                // 3 Total outflow
                $out = $mouvements->sum('montant');

                // 4 Computed true closing balance
                $computed = $box->start_value + $in - $out;

                // 5 "Running" end_value = what's in the DB or the computed fallback
                $running = $box->end_value !== null
                         ? $box->end_value
                         : $computed;

                return [
                    $date => [
                        'created_at'       => $box->created_at,
                        'start'            => $box->start_value,
                        'entree'           => $in,
                        'sortie'           => $out,
                        'computed'         => $computed,
                        'solde'            => $running,                // legacy key
                        'end_value'        => $running,                // what your Blade reads now
                        'manual_end_value' => $box->manual_end_value,  // user‐typed value
                        'manual_end_set'   => $box->manual_end_set,    // true/false flag
                        'updated_at'       => $box->updated_at,
                        'mouvements'       => $mouvements,             // for any badge logic
                        'decalage'         => $box->decalage,
                    ],
                ];
            })
            ->toArray();
    }

    public function view(string $date): void
    {
        // Refresh balances so totals are current
        $this->loadBalances();

        $this->selectedDate = $date;
        $this->startValue = Cashbox::whereDate('created_at', $date)->value('start_value') ?? 0;
        $this->inflow = Factures::whereDate('created_at', $date)->sum('total_amount');

        // Sum exactly the same outflows as in loadBalances():
        $this->outflow = CaisseHistorique::whereDate('created_at', $date)
                        ->sum('montant');
        $this->total = $this->startValue + $this->inflow - $this->outflow;

        $this->facturesOfDay = Factures::whereDate('created_at', $date)->with(['client', 'car'])->get();
        $this->mouvementsOfDay = CaisseHistorique::whereDate('created_at', $date)->get();

        // End value details
        $this->endEditDate = $date;
        $this->endValue = Cashbox::whereDate('created_at', $date)->value('end_value') ?? $this->total;
        $this->actualCashCount = Cashbox::whereDate('created_at', $date)->value('manual_end_value') ?? $this->total;
        $this->decalage = Cashbox::whereDate('created_at', $date)->value('decalage') ?? 0;

    }

    public function editEndValue(string $date): void
    {
        $this->endEditDate = $date;
        $cashbox = Cashbox::whereDate('created_at', $date)->first();

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

        // Calculate décalage: difference between expected total and actual cash count
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
        $date = Carbon::parse($this->endEditDate ?: $this->selectedDate)
                      ->toDateString();

        // 1) Fetch the model instance for Day N
        $todayBox = Cashbox::whereDate('created_at', $date)->first();

        if (! $todayBox) {
            session()->flash('error', 'Cashbox not found for ' . $date);
            return;
        }

        // 2) Mutate and save—this will fire CashboxObserver::updated()
        $todayBox->end_value = $this->actualCashCount; // Use the actual cash count as end value
        $todayBox->manual_end_value = $this->actualCashCount;
        $todayBox->manual_end_set = true;
        $todayBox->decalage = $this->decalage;
        $todayBox->save();   // ← **must** use save() to trigger the observer

        // 3) Reload balances for UI
        $this->loadBalances();

        // 4) Reset modal if open
        $this->showEndModal = false;

        session()->flash('message', 'Cash count and discrepancy saved successfully.');
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
