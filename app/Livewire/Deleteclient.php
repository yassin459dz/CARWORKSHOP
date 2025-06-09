<?php

namespace App\Livewire;
use App\Models\clients;
use Livewire\Component;

class Deleteclient extends Component
{
    public $clientId;
    public $clientName;
    public $prefix = ''; // Add prefix property


    public function render()
    {
        return view('livewire.clients.deleteclient');
    }
    public function mount($clientId)
    {
        // Find the client by ID and assign their name to the property
        $client = clients::find($clientId);
        $this->clientId = $clientId;
        $this->clientName = $client->name; // Fetching the client name
    }

    public function deleteClient()
    {

        // Fetch the client by ID and delete
        $client = clients::findOrFail($this->clientId);

        $client->delete();

        // Optionally emit an event or redirect after deletion
        $this->dispatch('clientDeleted');
        $clientName = $client->name; // Get the client name
        $client->delete(); // Delete the client
        session()->flash('status-delete', "{$clientName} has been deleted."); // Use string interpolation
        return $this->redirect('/client', navigate: true); // Redirect after deletion

    }


}
