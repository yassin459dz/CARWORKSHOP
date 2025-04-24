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

    public ?string $endEditDate = null;
    public ?float $endValue = null;
    public bool $showEndModal = false;

    public function mount()
    {
        // Ensure a cashbox record exists for today
        $today = Carbon::today();
        if (! Cashbox::whereDate('created_at', $today)->exists()) {
            $yesterdayBox = Cashbox::latest('created_at')->first();
            Cashbox::create([
                'start_value' => $yesterdayBox?->end_value ?? 0,
            ]);
        }

        $this->loadBalances();
    }

    public function loadBalances(): void
    {
        $this->dailyBalances = Cashbox::orderBy('created_at', 'desc')
            ->get()
            ->mapWithKeys(function (Cashbox $box) {
                $date = $box->created_at->toDateString();
                $in = Factures::whereDate('created_at', $date)->sum('total_amount');
                $out = CaisseHistorique::whereDate('created_at', $date)
                    ->where('type', 'SORTIE')
                    ->sum('montant');
                $solde = $box->start_value + $in - $out;

                return [
                    $date => [
                        'start'  => $box->start_value,
                        'entree' => $in,
                        'sortie' => $out,
                        'solde'  => $solde,
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
                   ->update(['end_value' => $this->endValue]);

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
