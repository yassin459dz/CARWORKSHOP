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
    public $duration;

    public function edit($id){
        $this->client = clients::findOrFail($id);
        $this->name = $this->client->name;
        $this->phone = $this->client->phone;
        $this->phone2 = $this->client->phone2;
        $this->address = $this->client->address;
        $this->remark = $this->client->remark;
        $this->sold = $this->client->sold;
        $this->date = $this->client->created_at->format('d/F/Y');
        $this->updated = $this->client->updated_at;

        // Calculate duration using Carbon
        $created = $this->client->created_at;
        $now = \Carbon\Carbon::parse('2025-05-27T23:56:04+01:00');
        $years = $created->diffInYears($now);
        $months = $created->copy()->addYears($years)->diffInMonths($now);
        $days = $created->copy()->addYears($years)->addMonths($months)->diffInDays($now);
        $parts = [];
        if ($years > 0) $parts[] = $years . ' year' . ($years > 1 ? 's' : '');
        if ($months > 0) $parts[] = $months . ' month' . ($months > 1 ? 's' : '');
        if ($days > 0) $parts[] = $days . ' day' . ($days > 1 ? 's' : '');
        if (empty($parts)) $parts[] = '0 days';
        $this->duration = implode(', ', $parts);
    }
    public function render()
    {
        return view('livewire.clients.view-client');
    }



}
