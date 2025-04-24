<?php

namespace App\Livewire;
use App\Models\Products;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateEditProduct extends Component
{
    public $formtitle='New Product';
    public $editform=false;
    public $viewform=false;

    public $productss;

    #[Rule('required')]
    public $product;
    public $name;
    public $description;
    public $price;
    public $product_id;

    public function render()
    {
        return view('livewire.products.create-edit-product');
    }

    public function save()
    {
        // Validate inputs
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ], [
            'name.required' => 'Product Name is Required',
            'price.required' => 'Price is Required'
        ]);
        // Create new product
        Products::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ]);

        // Reset form fields
        // $this->reset(['name', 'description', 'price']);
        return $this->redirect(request()->header('Referer'), navigate: true);

        // Flash success message
        session()->flash('status-created', 'Product created successfully!');

        // Dispatch event to refresh products in parent component
        // $this->dispatch('product-created');

        // // Close modal
        // $this->dispatch('closeModal');
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
        $this->formtitle = 'Edit Product';
        $this->productss = Products::findOrFail($id);
        $this->name = $this->productss->name;
        $this->description = $this->productss->description;
        $this->price = $this->productss->price;
        $this->product_id = $id;
    }

    #[On('view-mode')]
    public function view($id)
    {
        $this->viewform = true;
        $this->formtitle = 'View Product';
        $this->productss = Products::findOrFail($id);
        $this->name = $this->productss->name;
        $this->description = $this->productss->description;
        $this->price = $this->productss->price;
        $this->product_id = $id;
    }

    public function update()
    {
        // Validate the incoming request data
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        // Find the product by ID and update it
        $product = Products::findOrFail($this->product_id);
        $product->name = $this->name;
        $product->description = $this->description;
        $product->price = $this->price;

        // Save changes
        $product->save();

        // Reset form fields
        $this->reset(['name', 'description', 'price', 'editform']);
        $this->formtitle = 'New Product';

        // Flash success message
        session()->flash('status-updated', 'Product Updated');

        // Dispatch event to refresh products in parent component
        $this->dispatch('product-updated');

        // Close modal
        $this->dispatch('closeModal');
    }
    public function refreshPage()
    {
        $url = request()->header('Referer') ?? url()->current();
        return $this->redirect($url, navigate: true);
    }
}
