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
        $factures = Factures::all();
        return view('livewire.FACTURE.list-facture', compact('factures'));
    }

}
