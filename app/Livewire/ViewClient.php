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
    public $phone2;
    public $address;
    public $remark;
    public $sold;   
    public $client;
    public $date;
    public $updated;

    public $updated_at;

    protected $listeners = ['edit-mode' => 'edit'];

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
        $this->phone2=$this->client->phone2;
        $this->address=$this->client->address;
        $this->remark=$this->client->remark;
        $this->sold=$this->client->sold;
        $this->date = $this->client->created_at->format('d/F/Y');
        $this->updated=$this->client->updated_at;

    }
    public function render()
    {
        return view('livewire.clients.view-client');
    }



}
