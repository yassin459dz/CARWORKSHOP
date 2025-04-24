<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use App\Models\Product;
use Livewire\Component;

class Pos extends Component
{
    public $product;


    public function render()
    {
        return view('livewire.pos');
    }


    public function mount(){

        $this->product = Product::all();
    }

    


}
