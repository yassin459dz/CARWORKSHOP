<?php

namespace App\Livewire;
use App\Models\brands;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

class CreateEditBrand extends Component
{
    public $formtitle='Create Brand';
    public $editform=false;

    public $brandss;

    #[Rule('required')]
    public $brand;

    #[Rule('nullable')]
    public $image;



    public function render()
    {
        return view('livewire.brands.create-edit-brand');
    }

    public function save (){
        $validated=$this->validate();
        brands::create($validated);
        $this->dispatch('refresh-clients');
        // session()->flash('status', 'Client Created');
        // session()->flash('status-created', 'Client Created');
        $this->close();// ADD THIS TO REFRESH PAGE WITH PHP
        $this->dispatch('browser', 'close-modal');
        return $this->redirect('/brand', navigate:true);
    }

    #[On('reset-modal')]
    public function close(){
        $this->reset();
    }

    #[On('edit-mode')]
    public function edit($id){
        // dd($id);
        $this->editform=true;
        $this->formtitle='Edit Brand';
        $this->brandss=brands::findOrFail($id);
        $this->brand=$this->brandss->brand;
        $this->image=$this->brandss->image;
    }

    public function update(){
        $validated=$this->validate();
        $p=brands::findOrFail($this->brandss->id);
        $p->update($validated);
        $this->dispatch('refresh-brands');
        session()->flash('status-updated', value: 'Brand Updated');
        $this->dispatch('browser', 'close-modal');

    }

    public function refreshPage()
    {
        // Any logic you want to run before refresh (optional)

        // Redirect to the same route to refresh the page
        return $this->redirect('/brand', navigate:true);

    }
}
