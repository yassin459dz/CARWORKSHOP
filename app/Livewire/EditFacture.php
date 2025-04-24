<?php
namespace App\Livewire;

use App\Models\Factures;
use App\Models\brands;
use App\Models\cars;
use App\Models\clients;
use App\Models\matricules;
use App\Models\Products;
use Livewire\Component;
use Illuminate\Support\Facades\Log;


class EditFacture extends Component
{
    public $currentstep = 3;
    public $totalstep = 3;
    public $factureId; // Add this line
    public $facture; // Add this line

    public $client_id;
    public $phone;
    public $status;
    public $allbrands;
    public $allclients;
    public $car;
    public $allcars;
    public $car_id;
    public $search = '';
    public $allmat;
    public $matt;
    public $mat_id;
    public $km;
    public $product;
    public $qte;
    public $price;
    public $total;
    public $remark;
    public $mat = '';

    // public $orderItems = '[]';
    public $orderItems = []; // Initialize as an empty array, not a string

    public $total_amount = 0;
    public $extraCharge = 0;
    public $discountAmount = 0;
    // Remove the update tracking properties since we'll handle this in Alpine.js only
    public $tempExtraCharge = 0;
    public $tempDiscountAmount = 0;

    public function render()
    {
        return view('livewire.facture.Edit-Facture', [
            'facture' => $this->facture
        ]);
    }

    public function mount($edit = null)
    {
        $this->factureId = $edit;
        $this->product = Products::all();
        $this->allcars = cars::all();
        $this->allclients = clients::all();
        $this->allmat = matricules::all();
        $this->allbrands = brands::all();

        if ($this->factureId) {
            $this->facture = Factures::find($this->factureId);
            if ($this->facture) {
                $this->client_id = $this->facture->client_id;
                $this->car_id = $this->facture->car_id;
                $this->mat_id = $this->facture->matricule_id;
                $this->km = $this->facture->km;
                $this->remark = $this->facture->remark;
                $this->orderItems = $this->facture->order_items;
                $this->total_amount = $this->facture->total_amount;
                // Initialize the update tracking properties
                $this->extraCharge = (float) $this->facture->extra_charge;
                $this->tempExtraCharge = (float) $this->facture->extra_charge;
                $this->discountAmount = (float) $this->facture->discount_amount;
                $this->tempDiscountAmount = (float) $this->facture->discount_amount;

                // Set search values for dropdowns
                $this->search = $this->facture->client->name ?? '';
                $this->mat = $this->facture->matricule->mat ?? '';
            }
        }
    }





    public function incrementstep()
    {
        $this->validateForm();
        if ($this->currentstep < $this->totalstep) {
            $this->currentstep++;
        }
    }

    public function decrementstep()
    {
        if ($this->currentstep > 1) {
            $this->currentstep--;
        }
    }

    public function validateForm()
    {
        if ($this->currentstep === 1) {
            $validated = $this->validate([
                'client_id' => 'required',
            ], [
                'client_id.required' => 'Please select a Client',
            ]);
        } elseif ($this->currentstep === 2) {
            $validated = $this->validate([
                'remark' => 'nullable',
            ]);
        } elseif ($this->currentstep === 3) {
            $validated = $this->validate([
                // Validation rules for step 3
            ]);
        }
    }

    public function createMatricule()
    {
        if (!$this->client_id || !$this->car_id || !$this->mat) {
            $this->addError('mat', 'Client and Car must be selected first');
            return null;
        }

        $existingMatricule = matricules::where('mat', $this->mat)
            ->where('client_id', $this->client_id)
            ->where('car_id', $this->car_id)
            ->first();

        if ($existingMatricule) {
            $this->mat_id = $existingMatricule->id;
            return $existingMatricule->id;
        }

        $matricule = matricules::create([
            'client_id' => $this->client_id,
            'car_id' => $this->car_id,
            'mat' => $this->mat,
        ]);

        $this->mat_id = $matricule->id;
        $this->allmat = matricules::all();

        return $matricule->id;
    }

    // Add methods to handle Alpine.js updates

    public function update()
    {
        // Ensure orderItems is an array
        $orderItems = is_array($this->orderItems) ? $this->orderItems : json_decode($this->orderItems, true);

        if (count($orderItems) === 0) {
            session()->flash('error', 'No items in the order');
            return;
        }

        $processedOrderItems = array_map(function ($item) {
            return [
                'product_id' => $item['id'] ?? null,
                'name' => $item['name'] ?? null,
                'description' => $item['description'] ?? null,
                'quantity' => $item['quantity'] ?? 0,
                'price' => $item['price'] ?? 0,
                'total' => ($item['quantity'] ?? 0) * ($item['price'] ?? 0),
            ];
        }, $orderItems);

        // $totalAmount = collect($processedOrderItems)->sum(fn($item) => $item['quantity'] * optional($item)['price']) + $this->extraCharge - $this->discountAmount;
        // $totalAmount = collect($processedOrderItems)->sum('total') + $this->extraCharge - $this->discountAmount;
  // Calculate total with updated charges and discounts
        // Calculate total with the final submitted values
        $totalAmount = collect($processedOrderItems)->sum('total') +
                      (float) $this->extraCharge -
                      (float) $this->discountAmount;

        // Ensure facture ID exists for update
        if (!$this->factureId) {
            session()->flash('error', 'Facture not found');
            return;
        }

        $facture = Factures::find($this->factureId);

        // Ensure facture is found
        if (!$facture) {
            session()->flash('error', 'Facture not found');
            return;
        }

        // Update facture
        $facture->update([
            'client_id' => $this->client_id,
            'car_id' => $this->car_id,
            'matricule_id' => $this->mat_id,
            'km' => $this->km,
            'remark' => $this->remark,
            'order_items' => json_encode($processedOrderItems, JSON_THROW_ON_ERROR),
            'total_amount' => $totalAmount,
            'extra_charge' => (float) $this->extraCharge,
            'discount_amount' => (float) $this->discountAmount,
            'updated_at' => now(),
        ]);

        session()->flash('status-updated', 'Facture updated successfully!');
        // return redirect()->route('factures.index');
    }


}
