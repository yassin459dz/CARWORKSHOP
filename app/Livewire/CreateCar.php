<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\cars;
use App\Models\brands;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;


class CreateCar extends Component
{

    public $allbrands;
    public $formtitle = 'Create Car';
    public $editform = false;

    public $brandform = false;

    public $carss;

    // #[Rule('required')]
     public $brand_id;  // Added property

    // #[Rule('required')]
     public $model;

     public $car_id;


    // #[Rule('nullable')]
     public $brand;  // Added property

    // #[Rule('nullable')]
    public $image;

    public function boot()
    {
        // $this->allbrands = cars::all();
        // $this->allbrands = cars::with('brand')->get(); // Use "brand" instead of "brands"
        $this->allbrands = brands::all(); // Retrieve all brands

    }

    public function render()
    {
        return view('livewire.cars.create-car');
    }

    public function save()
    {
    // Try To Validate With Array
    $validated = $this->validate(
        [
            'brand_id' => 'required|exists:brands,id',
            'model' => 'required|string|max:255',
        ]);
     cars::create([
         'brand_id' => $this->brand_id,
         'model' => $this->model,

    ]);

    // Clear form fields and dispatch events
    session()->flash('status-updated', 'Car created successfully!');
    $this->dispatch('refresh-cars');
    $this->close(); // Reset fields

    // Redirect or close modal if needed
    $this->dispatch('browser', 'close-modal');
    return $this->redirect('/car', navigate: true);

    }

    #[On('reset-modal')]
    public function close()
    {
        $this->reset();
    }

    #[On('edit-mode')]
    public function edit($id)
    {
        $this->editform = true;
        $this->formtitle = 'Edit Client';
        $this->carss = Cars::findOrFail($id); // Fetch the car data by ID
        $this->brand_id = $this->carss->brand_id;  // Set brand_id for edit
        $this->model = $this->carss->model;
        $this->car_id = $id;  // Store the ID for use in the update

    }

    public function update()
    {
    // Validate the incoming request data
        // Validate the incoming request data
        $validatedData = $this->validate([
            'brand_id' => 'required|exists:brands,id',
            'model' => 'required|string|max:255',
        ]);
        // Validate input data (you can add more validation rules as needed)
        $this->validate([
            'brand_id' => 'required|integer',
            'model' => 'required|string|max:255',
        ]);
        // Find the car entry by ID and update it with the new data
        $car = Cars::findOrFail($this->car_id);
        $car->brand_id = $this->brand_id;
        $car->model = $this->model;
        // Save the changes to the database
        $car->save();
        //  reset the form  after updating
        $this->dispatch('refresh-cars');
        //success message or perform other actions
        session()->flash('status-updated', 'Car Updated');
        $this->dispatch('browser', 'close-modal');
    }

    #[On('brand-mode')]
    public function addbrand()
    {
        $this->brandform = true;
        $this->formtitle = 'Create Brand';


    }
    #[On('brand-mode')]
    public function closebrand()
    {
        $this->brandform = false;
        $this->formtitle = 'Create Car';

    }

    public function submit (){
        $validated = $this->validate(
            [
                'brand' => 'required|string|max:255',
                'image' => 'required|string|max:255',
            ]);
            brands::create([
             'brand' => $this->brand,
             'image' => $this->image,

        ]);
        $this->brandform = false;
        $this->fetchBrands(); // Call a method to refresh brands

    }

    // Method to fetch all brands
    public function fetchBrands()
    {
        $this->allbrands = brands::all(); // Assuming you're storing brands in this property
    }


    public function refreshPage()
    {
        // Any logic you want to run before refresh (optional)

        // Redirect to the same route to refresh the page
        return $this->redirect('/car', navigate:true);

    }
}
