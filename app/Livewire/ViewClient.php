<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;
use App\Models\clients;
use App\Models\Factures;
class ViewClient extends Component
{
    public $editMode = false;
    public $originalData = [];
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
    public $factureCount;

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
        $this->factureCount = Factures::where('client_id', $this->client->id)->count();
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
    public function enableEditMode()
    {
        $this->originalData = [
            'name' => $this->name,
            'phone' => $this->phone,
            'phone2' => $this->phone2,
            'address' => $this->address,
            'remark' => $this->remark,
        ];
        $this->editMode = true;
    }

    public function saveEdit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'phone2' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'remark' => 'nullable|string',
        ]);
        $this->client->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'phone2' => $this->phone2,
            'address' => $this->address,
            'remark' => $this->remark,
        ]);
        $this->editMode = false;
        $this->updated = $this->client->fresh()->updated_at;
    }

    public function cancelEdit()
    {
        foreach ($this->originalData as $key => $value) {
            $this->$key = $value;
        }
        $this->editMode = false;
        // Emit event to reset the CreateEditClient form
        $this->dispatch('reset-create-client');
    }

    public function render()
    {
        return view('livewire.clients.view-client');
    }



}
