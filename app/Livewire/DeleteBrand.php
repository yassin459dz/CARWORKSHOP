<?php

namespace App\Livewire;
use App\Models\brands;
use Livewire\Component;

class DeleteBrand extends Component
{
    public $brandId;
    public $brandName;

     public function render()
     {
         return view('livewire.brands.deletebrand');
     }

    public function mount($brandId)
    {
        // Find the client by ID and assign their name to the property
        $brand = brands::find($brandId);
        $this->brandId = $brandId;
        $this->brandName = $brand->brand; // Fetching the client name
    }

    public function deleteBrand()
    {
        // Fetch the client by ID and delete
        $brand = brands::findOrFail($this->brandId);
        $brand->delete();
        // Optionally emit an event or redirect after deletion
        $this->dispatch('brandDeleted');
        $brandName = $brand->brand; // Get the client name
        $brand->delete(); // Delete the client
        session()->flash('status-delete', "{$brandName} has been deleted."); // Use string interpolation
        return $this->redirect('/brand', navigate: true); // Redirect after deletion
    }
}
