<?php

namespace App\Livewire;
use App\Models\CaisseHistorique;

use Livewire\Component;

class Deponse extends Component
{
    public $start;
    public $deponse;
    public $total;
    public $type;
    public $montant;
    public $desc;


    public function render()
    {
        return view('livewire.Cashbox.deponse');
    }

    public function save()
    {
        try {
            // Validate with array
            $validated = $this->validate([
                // 'type' => 'required',
                'montant' => 'required|numeric',
            ]);

            CaisseHistorique::create([
                // 'type' => $this->type,
                'montant' => $this->montant,
                'description' => $this->desc,
            ]);

            // You might want to add success handling here
            // For example: $this->dispatch('notify', message: 'Record saved successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->getMessageBag();

            // Get the first error message
            $errorMessage = $errors->first();

            // Customize the message
            // $customMessage = "Error: Select Entrée Or Sortie ." ; // Example of customization
            // Or you could do more specific customization:
            // if (str_contains($errorMessage, 'type')) {
            //     $customMessage = "Please select a type before proceeding.";
            // }

            // Dispatch with custom message
            // $this->dispatch('showAlert', message: $customMessage);

            throw $e;
        }
    }
}
