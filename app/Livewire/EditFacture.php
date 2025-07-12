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
use Livewire\Attributes\Computed;

class EditFacture extends Component
{
    public $currentstep = 1;
    public $totalstep = 3;
    public $factureId;
    public $facture;

    public $client_id;
    public $phone;
    public $status = 'NOT PAID';
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

    public $orderItems = [];
    public $total_amount = 0;
    public $extraCharge = 0;
    public $discountAmount = 0;
    public $tempExtraCharge = 0;
    public $tempDiscountAmount = 0;
    public $clientPaid = 0;


    public function render()
    {
        $groupedCars = $this->getGroupedCarsProperty();
        $clientSold = 0;
        $facture = $this->facture;
        
        if ($this->client_id) {
            $client = clients::find($this->client_id);
            $clientSold = $client ? $client->sold : 0;
        }
        
        return view('livewire.facture.Edit-Facture', compact('facture', 'groupedCars', 'clientSold'));
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
                $this->extraCharge = (float) $this->facture->extra_charge;
                $this->tempExtraCharge = (float) $this->facture->extra_charge;
                $this->discountAmount = (float) $this->facture->discount_amount;
                $this->tempDiscountAmount = (float) $this->facture->discount_amount;
                $this->clientPaid = $this->facture->paid_value ?? 0;
                $this->status = $this->facture->status ?? 'NOT PAID';

                $this->search = $this->facture->client->name ?? '';
                $this->mat = $this->facture->matricule->mat ?? '';
            }
        }
    }

    #[Computed()]
    public function getGroupedCarsProperty(): array
    {
        if (!$this->client_id) {
            return ['Owned Car' => collect(), 'Non Owned Car' => collect()];
        }

        $ownedCarIds = matricules::where('client_id', $this->client_id)
            ->pluck('car_id')
            ->toArray();

        $ownedCars = $this->allcars->filter(fn($car) => in_array($car->id, $ownedCarIds));
        $nonOwnedCars = $this->allcars->filter(fn($car) => !in_array($car->id, $ownedCarIds));

        return [
            'Owned Car'     => $ownedCars,
            'Non Owned Car' => $nonOwnedCars,
        ];
    }

    #[Computed]
    public function filteredMatricules()
    {
        if ($this->client_id && $this->car_id) {
            return matricules::where('client_id', $this->client_id)
                ->where('car_id', $this->car_id)
                ->get();
        }
        return collect();
    }

    public function updatedClientId($value)
    {
        $this->car_id = null;
        $this->mat_id = null;
        $this->mat = '';
        $this->search = '';

        if ($value) {
            $client = clients::find($value);
            $this->search = $client->name ?? '';
            $this->autoSelectCarAndMatricule();
        }
        $this->render();

    }

    public function updatedCarId($value)
    {
        $this->mat_id = null;
        $this->mat = '';

        if ($value && $this->client_id) {
            $matricules = matricules::where('client_id', $this->client_id)
                ->where('car_id', $value)
                ->get();

            if ($matricules->count() === 1) {
                $this->mat_id = $matricules->first()->id;
                $this->mat = $matricules->first()->mat;

                $this->dispatch('auto-select-matricule', [
                    'matriculeId' => $this->mat_id,
                    'matriculeName' => $this->mat,
                ]);
            }
        }
    }

    public function updatedMatId($value)
    {
        if ($value) {
            $matricule = matricules::find($value);
            $this->mat = $matricule->mat ?? '';
        } else {
            $this->mat = '';
        }
    }

    private function autoSelectCarAndMatricule()
    {
        if (!$this->client_id) return;

        $ownedCarIds = matricules::where('client_id', $this->client_id)
            ->pluck('car_id')
            ->unique()
            ->toArray();

        if (count($ownedCarIds) === 1) {
            $this->car_id = $ownedCarIds[0];

            $car = cars::find($this->car_id);
            $this->dispatch('auto-select-car', [
                'carId' => $this->car_id,
                'carName' => $car->model ?? '',
            ]);

            $matricules = matricules::where('client_id', $this->client_id)
                ->where('car_id', $this->car_id)
                ->get();

            if ($matricules->count() === 1) {
                $this->mat_id = $matricules->first()->id;
                $this->mat = $matricules->first()->mat;

                $this->dispatch('auto-select-matricule', [
                    'matriculeId' => $this->mat_id,
                    'matriculeName' => $this->mat,
                ]);
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
            $this->validate([
                'client_id' => 'required|exists:clients,id',
            ], [
                'client_id.required' => 'Please select a Client',
            ]);
    
        } elseif ($this->currentstep === 2) {
            $this->validate([
                'remark' => 'nullable',
            ]);
        } elseif ($this->currentstep === 3) {
            // Validation rules for step 3 can go here
        }
    }


    public function createMatricule()
    {
        if (!$this->client_id || !$this->car_id || !$this->mat) {
            $this->addError('mat', 'Client and Car must be selected first');
            return null;
        }

        $existing = matricules::where('mat', $this->mat)
            ->where('client_id', $this->client_id)
            ->where('car_id', $this->car_id)
            ->first();

        if ($existing) {
            $this->mat_id = $existing->id;
            return $existing->id;
        }

        $matricule = matricules::create([
            'client_id' => $this->client_id,
            'car_id' => $this->car_id,
            'mat' => $this->mat,
        ]);

        $this->mat_id = $matricule->id;
        $this->allmat = matricules::all();

        $this->dispatch('matricule-created', [
            'id' => $matricule->id,
            'mat' => $matricule->mat,
        ]);

        return $matricule->id;
    }

    public function update()
    {
        $orderItems = is_array($this->orderItems)
            ? $this->orderItems
            : json_decode($this->orderItems, true);
    
        if (count($orderItems) === 0) {
            session()->flash('error', 'No items in the order');
            return;
        }
    
        $processedOrderItems = array_map(fn($item) => [
            'product_id' => $item['id'] ?? null,
            'name' => $item['name'] ?? null,
            'description' => $item['description'] ?? null,
            'quantity' => $item['quantity'] ?? 0,
            'price' => $item['price'] ?? 0,
            'total' => ($item['quantity'] ?? 0) * ($item['price'] ?? 0),
        ], $orderItems);
    
        $totalAmount = collect($processedOrderItems)->sum('total') +
                      (float) $this->extraCharge -
                      (float) $this->discountAmount;
    
        if (!$this->factureId || !$this->facture) {
            session()->flash('error', 'Facture not found');
            return;
        }
    
        $client = clients::findOrFail($this->client_id);
        $currentSold = (float)($client->sold ?? 0);
    
        // Store original values before update
        $originalPaidValue = (float)$this->facture->paid_value;
        $originalTotalAmount = (float)$this->facture->total_amount;
        $originalRemaining = $originalTotalAmount - $originalPaidValue;
    
        // Calculate new remaining and status
        if ($this->clientPaid > 0) {
            $newRemaining = $totalAmount - $this->clientPaid;
            $this->status = $newRemaining > 0 ? 'NOT PAID' : 'PAID';
        } else {
            $this->clientPaid = $totalAmount;
            $newRemaining = 0;
            $this->status = 'PAID';
        }
    
        // Adjust client sold: remove old debt, add new debt
        $client->sold = $currentSold - $originalRemaining + max(0, $newRemaining);
        $client->save();
    
        $paidValue = $this->clientPaid > 0 ? $this->clientPaid : $totalAmount;
    
        $this->facture->update([
            'client_id' => $this->client_id,
            'car_id' => $this->car_id,
            'matricule_id' => $this->mat_id,
            'km' => $this->km,
            'remark' => $this->remark,
            'order_items' => json_encode($processedOrderItems, JSON_THROW_ON_ERROR),
            'total_amount' => $totalAmount,
            'extra_charge' => (float) $this->extraCharge,
            'discount_amount' => (float) $this->discountAmount,
            'paid_value' => $paidValue,
            'status' => $this->status,
            'updated_at' => now(),
        ]);
    
        session()->flash('status-updated', 'Facture updated successfully!');
    }
}
