<?php

use Livewire\Component;
use App\Models\Factures;

class FactureHistory extends Component
{
    public $clientId;
    public $carId;

    public function mount($clientId, $carId)
    {
        $this->clientId = $clientId;
        $this->carId = $carId;
    }

    public function render()
    {
        $factures = Factures::with(['client', 'car', 'matricule'])
            ->where('client_id', $this->clientId)
            ->where('car_id', $this->carId)
            ->get();

        return view('livewire.facture-history', compact('factures'));
    }
}

