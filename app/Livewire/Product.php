<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Products;

class Product extends Component
{

    public function render()
    {
        $products = Products::paginate(10);
        return view('livewire.products.product', compact('products'));
    }

}
