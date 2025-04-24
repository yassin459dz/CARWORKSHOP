<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;
use App\Models\clients;

class ViewClient extends Component
{
    public $name;
    public $phone;

    public $client;

    protected $listeners = ['showClient' => 'loadClient'];

    // public function loadClient($client)
    // {
    //     $this->name = $client['name'];
    //     $this->phone = $client['phone'];
    // }
    public function edit($id){
        // dd($id);

        $this->client=clients::findOrFail($id);
        $this->name=$this->client->name;
        $this->phone=$this->client->phone;

    }
    public function render()
    {
        return view('livewire.clients.view-client');
    }



}
