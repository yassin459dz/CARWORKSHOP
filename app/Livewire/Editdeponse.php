<?php

namespace App\Livewire;
use App\Models\CaisseHistorique;

use Livewire\Component;

class EditDeponse extends Component
{
    public $id;
    public $montant;
    public $desc;

    public function mount($id)
    {
        $this->id = $id;

        // Fetch data for the specific ID from CaisseHistorique
        $caisseHistorique = CaisseHistorique::findOrFail($id); // Fetch the record by ID
        $this->montant = $caisseHistorique->montant;
        $this->desc = $caisseHistorique->description;
    }

    public function save()
    {
        // Handle saving the changes
        $caisseHistorique = CaisseHistorique::find($this->id);
        $caisseHistorique->montant = $this->montant;
        $caisseHistorique->desc = $this->desc;
        $caisseHistorique->save();

        // You can trigger success alert here
        session()->flash('message', 'Data updated successfully!');
    }

    public function render()
    {
        return view('livewire.editdeponse');
    }
}
