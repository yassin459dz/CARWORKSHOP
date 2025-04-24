<?php

namespace App\Livewire;
use App\Models\cars;
use Livewire\Component;

class Deletecar extends Component
{
    public $carId;
    public $carName;
    public function render()
    {
        return view('livewire.cars.deletecar');
    }
    public function mount($carId)
    {
        // Find the client by ID and assign their name to the property
        $car = cars::find($carId);
        $this->carId = $carId;
        $this->carName = $car->model; // Fetching the client name
    }

    public function deleteCar()
    {
        // Fetch the client by ID and delete
        $car = cars::findOrFail($this->carId);
        $car->delete();
        // Optionally emit an event or redirect after deletion
        $this->dispatch('Car Deleted');
        $carName = $car->model; // Get the client name
        $car->delete(); // Delete the client
        session()->flash('status-delete', "{$carName} has been deleted."); // Use string interpolation
        return $this->redirect('/car', navigate: true); // Redirect after deletion
    }
}
