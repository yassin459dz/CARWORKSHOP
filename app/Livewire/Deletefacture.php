<?php

namespace App\Livewire;
use App\Models\Factures;

use Livewire\Component;

class Deletefacture extends Component
{
    public $factureId;
    public $factureNumber;

    public function render()
    {
        return view('livewire.facture.deletefacture');
    }

    public function mount($factureId)
    {
        $facture = Factures::find($factureId);
        $this->factureId = $factureId;
         $this->factureNumber = $facture->total_amount;
    }

    public function deleteFacture()
    {

        // Fetch the client by ID and delete
        $facture = factures::findOrFail($this->factureId);


        $facture->delete();

        // Optionally emit an event or redirect after deletion
        $this->dispatch('Facture Deleted');
        $factureNumber = $facture->id; //
        $facture->delete(); //
        session()->flash('status-delete', "THE Facture {$facture->total_amount} DA has been deleted."); // Use string interpolation
        return $this->redirect('/allfacture', navigate: true); // Redirect after deletion

    }
}
