<?php

namespace App\Livewire;
use App\Models\Factures;
use App\Models\cars;
use App\Models\matricules;
use Livewire\WithPagination;

use Livewire\Component;

class ListFacture extends Component
{
    public $status;

    use WithPagination;


    public function render()
    {
        // $this->factures=Factures::all();
        // $this->factures = Factures::with('client')->get();

        // return view('livewire.FACTURE.list-facture');
        $factures = Factures::paginate(10);
        return view('livewire.FACTURE.list-facture', compact('factures'));
    }

}
