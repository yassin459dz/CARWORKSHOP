<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\clients; // Renamed from clients to Client
use Livewire\Attributes\On;
use Livewire\Features\SupportEvents\DispatchesBrowserEvents;

class Client extends Component
{
    public $client;
    public $name;
    public $phone;
    public $search = '';



    public function render()
    {
        $clients = clients::all();

        return view('livewire.clients.client', compact('clients'));
    }
    

}
