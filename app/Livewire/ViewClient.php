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
    public $showModal = false; // Add this property

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
    public $prefix = '';

    protected $listeners = ['edit-mode' => 'edit'];

    #[On('edit-mode')]
    public function edit($id)
    {
        $this->reset(['editMode', 'deleteMode']); // Reset modes first

        $this->clientId = $id;        // ← add this
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
        
        // Show the modal
        $this->showModal = true;
        
        // Dispatch JavaScript to show modal
        $this->dispatch('show-modal');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->editMode = false;
        $this->deleteMode = false;
        $this->dispatch('modal-closed');
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
        $name = $this->client->name;
        $this->client->delete();

        $this->dispatch('clientDeleted');
        $this->deleteMode = false;
        $this->closeModal();
        
        session()->flash('status-delete', "{$name} has been deleted.");
        return $this->redirect('/client', navigate: true);
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
        
        session()->flash('status-updated', 'Client updated successfully.');
    }

    public function cancelEdit()
    {
        if ($this->editMode) {
            foreach ($this->originalData as $key => $value) {
                $this->$key = $value;
            }
            $this->editMode = false;
        } else {
            $this->closeModal();
        }
        
        $this->dispatch('reset-create-client');
    }

    public function render()
    {
        return view('livewire.clients.view-client');
    }
}