<?php

namespace App\Livewire;
use App\Models\brands;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

class ViewBrand extends Component
{

    public $viewform=false;

    public $brandss;

    public $brand;

    public $image;
    public function render()
    {
        return view('livewire.brands.view-brand');
    }
    #[On('view-mode')]
    public function view($id){
        $this->viewform=true;
        $this->brandss=brands::findOrFail($id);
        $this->brand=$this->brandss->brand;
        $this->image=$this->brandss->image;
    }


    public function refreshPage()
    {
        // Any logic you want to run before refresh (optional)

        // Redirect to the same route to refresh the page
        return $this->redirect('/brand', navigate:true);

    }
}
