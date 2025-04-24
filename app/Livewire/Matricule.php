<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\matricules;

class Matricule extends Component
{
    use WithPagination;

    // Add this to specify which pagination theme to use
    protected $paginationTheme = 'tailwind';

    public $search = '';

    public function render()
    {
        // Fetch matricules with pagination and search filter
        // Fetch matricules with pagination and search filter
        $matricules = Matricules::withCount('factures')
            ->when($this->search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    // Search in matricules table (mat field)
                    $q->where('mat', 'like', '%' . $search . '%')
                    // Search in client table (name and phone fields)
                    ->orWhereHas('client', function($subq) use ($search) {
                        $subq->where('name', 'like', '%' . $search . '%')
                            ->orWhere('phone', 'like', '%' . $search . '%');
                    });
                });
            })
            ->paginate(10);

        return view('livewire.matricule.matricule', compact('matricules'));
    }

    #[On('refresh-matricules')]
    public function refreshCar()
    {
        $this->resetPage(); // Reset pagination when refreshed
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
