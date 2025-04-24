<?php

namespace App\Livewire;
use App\Models\Products;

use Livewire\Component;

class Deleteproduct extends Component
{
    public $product_id;
    public $ProductName;
    public $ProductDesq;

    public $product;

    public function render()
    {
        return view('livewire.products.deleteproduct');
    }

    public function mount($product_id)
    {
        $product = Products::find($product_id);
        $this->product_id = $product_id;
         $this->ProductName = $product->name;
         $this->ProductDesq = $product->description;

    }

    public function deleteProduct()
    {

        // Fetch the client by ID and delete
        $product = Products::findOrFail($this->product_id);


        $product->delete();

        // Optionally emit an event or redirect after deletion
        $this->dispatch('Product Deleted');
        $ProductName = $product->name; //
        $ProductDesq = $product->description; //

        $product->delete(); //
        session()->flash('status-delete', "{$ProductName} {$ProductDesq} has been deleted."); // Use string interpolation
        return $this->redirect('/product', navigate: true); // Redirect after deletion

    }
}
