<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\clients; // Renamed from clients to Client
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Features\SupportEvents\DispatchesBrowserEvents;

class Client extends Component
{
    public $client;
    public $name;
    public $phone;
    public $search = '';
    use WithPagination;


    public function render()
    {
        $query = clients::query();

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        $clients = $query->paginate(50);

        return view('livewire.clients.client', compact('clients'));
    }

    #[On('refresh-clients')]
    public function refreshCar()
    {
        $this->resetPage(); // Reset pagination when refreshed
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
