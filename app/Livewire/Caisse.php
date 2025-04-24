<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CaisseHistorique;
use App\Models\Factures;
class Caisse extends Component
{
    use WithPagination;
    public $searchDateFrom;
    public $searchDateTo;
    public $selectedDate;
    public $facturesOfDay = [];
    public $mouvementsOfDay = [];
    public $endEditDate;
    public $endValue;
    public $showEndModal = false;

    public function updatingSearchDateFrom()
    {
        $this->resetPage();
    }
    public function updatingSearchDateTo()
    {
        $this->resetPage();
    }
    public function render()
    {
        $entrees = Factures::selectRaw('DATE(created_at) as date, SUM(total_amount) as total_entree')
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        $sorties = CaisseHistorique::where('type', 'SORTIE')
            ->selectRaw('DATE(created_at) as date, SUM(montant) as total_sortie')
            ->groupByRaw('DATE(created_at)')
            ->get()
            ->mapWithKeys(fn ($item) => [\Carbon\Carbon::parse($item->date)->toDateString() => $item]);

        $dates = $entrees->keys()->merge($sorties->keys())->unique()->sort();

        $starts = CaisseHistorique::whereNotNull('start_value')
            ->selectRaw('DATE(created_at) as date, start_value')
            ->get()
            ->mapWithKeys(fn ($item) => [\Carbon\Carbon::parse($item->date)->toDateString() => $item->start_value]);

        $runningStart = 0;
        $dailyBalances = [];

        foreach ($dates as $date) {
            $date = \Carbon\Carbon::parse($date)->toDateString();
            $entree = $entrees[$date]->total_entree ?? 0;
            $sortie = $sorties[$date]->total_sortie ?? 0;

            if (isset($starts[$date])) {
                $runningStart = $starts[$date];
            }

            $solde = $runningStart + $entree - $sortie;

            $dailyBalances[$date] = [
                'start' => $runningStart,
                'entree' => $entree,
                'sortie' => $sortie,
                'solde' => $solde,
            ];

            $runningStart = $solde;
        }

        // ✅ CORRECT: maintenant on return tout proprement ici
        return view('livewire.Cashbox.caisse', compact(
            'dates', 'entrees', 'sorties', 'dailyBalances'
        ));
    }

    public function editEndValue($date)
    {
        $this->endEditDate = $date;
        $this->showEndModal = true;

        $this->endValue = CaisseHistorique::whereDate('created_at', $date)
            ->whereNotNull('end_value')
            ->orderByDesc('created_at')
            ->value('end_value');
    }

    public function saveEndValue()
    {
        if ($this->endEditDate && $this->endValue !== null) {
            // Find the latest movement for that date
            $existing = CaisseHistorique::whereDate('created_at', $this->endEditDate)
                ->orderByDesc('created_at')
                ->first();

            if ($existing) {
                // Update only the end_value
                $existing->update([
                    'end_value' => $this->endValue,
                ]);
            }

            $this->showEndModal = false;
            session()->flash('message', 'End value updated.');
        }
    }


    public function view($date)
    {
    $this->selectedDate = $date;
    $this->facturesOfDay = Factures::whereDate('created_at', $date)
        ->with(['client','car'])
        ->get();
    $this->mouvementsOfDay = CaisseHistorique::whereDate('created_at', $date)
        ->get();
    }
}
