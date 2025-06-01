<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;
use App\Models\clients;
use Livewire\Features\SupportEvents\DispatchesBrowserEvents;
class CreateEditClient extends Component
{
    protected $listeners = ['reset-create-client' => 'resetForm'];
    public $client;
    public $formtitle='Create Client';
    public $editform=false;

    public $liteform=false;


    #[Rule('required')]
    public $name;
    #[Rule('required')]
    public $phone;
    #[Rule('nullable')]

    public $phone2;
    
    public $address;
    public $remark;
    public $sold;





    public function render()
    {
        return view('livewire.clients.create-edit-client');
    }

    public function resetForm()
    {
        $this->reset(['name', 'phone', 'phone2', 'address', 'remark', 'sold', 'client']);
        $this->formtitle = 'Create Client';
        $this->editform = false;
        $this->liteform = false;
    }

    public function save (){
        $validated = $this->validate([
            'name' => 'required|unique:clients,name',
            'phone' => 'required|unique:clients,phone',
            'phone2' => 'nullable',
            'address' => 'nullable',
            'remark' => 'nullable',
            'sold' => 'nullable',
        ]);
        clients::create($validated);
        $this->dispatch('refresh-clients');
        // session()->flash('status', 'Client Created');
        // session()->flash('status-created', 'Client Created');
        $this->close();// ADD THIS TO REFRESH PAGE WITH PHP
        $this->dispatch('browser', 'close-modal');
        // Call the refreshPage function to handle the page refresh/redirect
        return $this->refreshPage();
    }

    #[On('reset-modal')]
    public function close(){
        $this->reset();
    }

    #[On('edit-mode')]
    public function edit($id){
        // dd($id);
        $this->editform=true;
        $this->formtitle='Edit Client';
        $this->client=clients::findOrFail($id);
        $this->name=$this->client->name;
        $this->phone=$this->client->phone;
        $this->phone2=$this->client->phone2;
        $this->address=$this->client->address;
        $this->remark=$this->client->remark;
        $this->sold=$this->client->sold;

    }

    public function update(){
        $validated=$this->validate();
        $p=clients::findOrFail($this->client->id);
        $p->update($validated);
        $this->dispatch('refresh-clients');
        session()->flash('status-updated', value: 'Client Updated');
        $this->dispatch('browser', 'close-modal');

    }

    public function refreshPage()
    {
        // Any logic you want to run before refresh (optional)

        // Redirect to the same route to refresh the page
        //return $this->redirect('/client', navigate:true);
        // Check if the current page is 'car' before refreshing
        // if (request()->is('client')) {
            // Perform the refresh if we're on the 'car' page


            //return $this->redirect('/client', navigate: true);
        // }else
        // {
        //     return $this->redirect('/facture', navigate: true);
        // }
            // Redirect to the same route to refresh the page
            // return $this->redirect('/car', navigate:true);
    }

    #[On('lite-mode')]
    public function lite(){
        // dd($id);
        $this->liteform=true;
        // $this->formtitle='lite mode';


    }

}
