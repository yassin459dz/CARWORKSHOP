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
    public $deleteMode = false;

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
    public $clientId;
    public $clientName;
    public $prefix = ''; // Add prefix property

    protected $listeners = ['edit-mode' => 'edit'];

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
    }

    public function enableEditMode()
    {
        $this->originalData = [
            'sold' => $this->sold,
            'name' => $this->name,
            'phone' => $this->phone,
            'phone2' => $this->phone2,
            'address' => $this->address,
            'remark' => $this->remark,
        ];
        $this->editMode = true;
    }

    public function enableDeleteMode()
    {
        $this->originalData = [
            'name' => $this->name,
        ];
        $this->deleteMode = true;

    }

    public function deleteClient()
    {
        if (!$this->client) {
            $this->dispatch('toast', 'No client selected.');
            return;
        }
    
        $id = $this->client->id;
        $this->client->delete();
    
        $this->dispatch('clientDeleted');
        $this->deleteMode = false;
        $this->name = $this->client->name;
        session()->flash('status-delete', "{$this->name} has been deleted."); // Use string interpolation
        return $this->redirect('/client', navigate: true); // Redirect after deletion

    
        // Emit custom event with deleted id
       // $this->dispatch('client-deleted', id: $id);
    }
    
    
    public function saveEdit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'phone2' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'remark' => 'nullable|string',
            'sold' => 'nullable|numeric',
        ]);
        $this->client->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'phone2' => $this->phone2,
            'address' => $this->address,
            'remark' => $this->remark,
            'sold' => $this->sold,
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
