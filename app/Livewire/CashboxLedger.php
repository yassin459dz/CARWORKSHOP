<?php

// Updated Livewire Component: app/Http/Livewire/CashboxLedger.php
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
    public $decalage = [];


    public ?string $endEditDate = null;
    public ?float $endValue = null;
    public bool $showEndModal = false;

    public function mount()
    {
        // Ensure a cashbox record exists for today
        $today = Carbon::today();//Determine Today’s Date
        // if (! Cashbox::whereDate('created_at', $today)->exists()) {//Check for an Existing Cashbox Record
        //     $yesterdayBox = Cashbox::latest('created_at')->first();
        //     Cashbox::create([
        //         'start_value' => $yesterdayBox?->end_value ?? 0,
        //     ]);
        // }

        $this->loadBalances();
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

                // 5 “Running” end_value = what’s in the DB or the computed fallback
                $running = $box->end_value !== null
                         ? $box->end_value
                         : $computed;

                return [
                    $date => [
                        'start'            => $box->start_value,
                        'entree'           => $in,
                        'sortie'           => $out,
                        'computed'         => $computed,
                        'solde'            => $running,                // legacy key
                        'end_value'        => $running,                // what your Blade reads now
                        'manual_end_value' => $box->manual_end_value,  // user‐typed value
                        'manual_end_set'   => $box->manual_end_set,    // true/false flag
                        'mouvements'       => $mouvements,             // for any badge logic
                        'decalage'          => $box->decalage,
                    ],
                ];
            })
            ->toArray();
    }



    public function view(string $date): void
    {
        // Refresh balances so totals are current
        $this->loadBalances();

        $this->selectedDate    = $date;
        $this->startValue      = Cashbox::whereDate('created_at', $date)
                                    ->value('start_value') ?? 0;
        $this->inflow          = Factures::whereDate('created_at', $date)
                                    ->sum('total_amount');
        $this->outflow         = CaisseHistorique::whereDate('created_at', $date)
                                    ->where('type', 'SORTIE')
                                    ->sum('montant');
        $this->total           = $this->startValue + $this->inflow - $this->outflow;

        $this->facturesOfDay   = Factures::whereDate('created_at', $date)
                                    ->with(['client', 'car'])
                                    ->get();
        $this->mouvementsOfDay = CaisseHistorique::whereDate('created_at', $date)
                                    ->get();
        $this->decalage      = $this->dailyBalances[$date]['decalage'];

            // ← ADD THESE TWO LINES:
    $this->endEditDate = $date;
    $this->endValue = Cashbox::whereDate('created_at', $date)
    ->value('end_value')
?? (
$this->dailyBalances[$date]['solde']
- collect($this->mouvementsOfDay)->sum('montant')
);

    }

    public function editEndValue(string $date): void
    {
        $this->endEditDate = $date;
        $this->endValue    = Cashbox::whereDate('created_at', $date)
                                ->value('end_value')
                            ?? $this->dailyBalances[$date]['solde'] ?? 0;
        $this->showEndModal = true;
    }

    public function saveEndValue(): void
    {
        $date = $this->endEditDate ?: $this->selectedDate;

        if ($date && $this->endValue !== null) {
            Cashbox::whereDate('created_at', $date)
            ->update([
                'end_value'        => $this->endValue,
                'manual_end_value' => $this->endValue,
                'manual_end_set'   => true,         // ← flip here
                'decalage'         => $this->decalage,

            ]);

            $this->loadBalances();
            session()->flash('message', 'End value updated.');
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
