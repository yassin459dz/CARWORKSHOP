<?php

namespace App\Livewire;

use App\Models\Factures;
use App\Models\brands;
use App\Models\cars;
use App\Models\clients;
use App\Models\matricules;
use App\Models\Products;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\Computed;

class Facture extends Component
{
    // ─────────────────────────────
    // 1. Public Properties
    // ─────────────────────────────
    public $clientPaid = 0;
    public $status = 'NOT PAID';
    public $currentstep = 1;
    public $totalstep = 3;

    public $client_id, $email, $phone, $fac, $gender;
    public $allbrands, $allclients, $allcars, $allmat;
    public $car, $car_id, $mat_id, $matt, $km, $mat = '';
    public $product, $qte, $price, $total, $remark, $search = '';

    public $orderItems = '[]';
    public $total_amount = 0;
    public $extraCharge = 0;
    public $discountAmount = 0;

    public $selectedClient = null;
    public $selectedMat = null;
    public $selectedCar = null;
    public $previousCarSelection = null;

    // ─────────────────────────────
    // 2. Lifecycle Hooks
    // ─────────────────────────────
    public function mount()
    {
        $this->product = Products::all();
        $this->fetchClients();
        $this->allcars = cars::all();
        $this->status = 'NOT PAID';
        $this->clientPaid = 0;
    }

    public function boot()
    {
        $this->allclients = clients::all();
        $this->allbrands = brands::all();
        $this->product = Products::all();

        if ($this->client_id) {
            $selectedClient = $this->allclients->where('id', $this->client_id)->first();
            if ($selectedClient) {
                $this->search = $selectedClient->name;
            }
        }

        if ($this->mat_id) {
            $selectedMatricule = $this->allmat->where('id', $this->mat_id)->first();
            if ($selectedMatricule) {
                $this->mat = $selectedMatricule->mat;
            }
        }
    }

    public function render()
    {
        $groupedCars = $this->getGroupedCarsProperty();
        $clientSold = 0;

        if ($this->selectedClient) {
            $client = clients::find($this->selectedClient);
            $clientSold = $client ? $client->sold : 0;
        }

        $filteredMatricules = $this->filteredMatricules;

        return view('livewire.Facture.facture', compact('groupedCars', 'clientSold', 'filteredMatricules'));
    }

    // ─────────────────────────────
    // 3. Computed Properties
    // ─────────────────────────────
    #[Computed()]
    public function getGroupedCarsProperty(): array
    {
        $ownedCarIds = $this->selectedClient
            ? matricules::where('client_id', $this->selectedClient)
                ->pluck('car_id')
                ->toArray()
            : [];

        $ownedCars = $this->allcars->filter(fn($car) => in_array($car->id, $ownedCarIds));
        $nonOwnedCars = $this->allcars->filter(fn($car) => !in_array($car->id, $ownedCarIds));

        return [
            'Owned Car' => $ownedCars,
            'Non Owned Car' => $nonOwnedCars,
        ];
    }

    #[Computed]
    public function filteredMatricules()
    {
        if ($this->selectedClient && $this->selectedCar) {
            return matricules::where('client_id', $this->selectedClient)
                ->where('car_id', $this->selectedCar)
                ->get();
        }
        return collect();
    }

    // ─────────────────────────────
    // 4. Updated Handlers
    // ─────────────────────────────
    public function updatedSelectedClient($value)
    {
        $this->selectedCar = null;
        $this->selectedMat = null;
        $this->mat = '';

        if ($value) {
            $this->autoSelectCarAndMatricule();
        }
    }

    public function updatedSelectedCar($value)
    {
        $this->selectedMat = null;
        $this->mat = '';

        if ($value && $this->selectedClient) {
            $matricules = matricules::where('client_id', $this->selectedClient)
                ->where('car_id', $value)
                ->get();

            if ($matricules->count() === 1) {
                $this->selectedMat = $matricules->first()->id;

                $this->dispatch('auto-select-matricule', [
                    'matriculeId' => $this->selectedMat,
                    'matriculeName' => $matricules->first()->mat,
                ]);
            }
        }
    }

    public function updatedSelectedMat($value)
    {
        if (!$value) {
            $this->mat = '';
        }
    }

    // ─────────────────────────────
    // 5. Step Navigation
    // ─────────────────────────────
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
                'selectedClient' => 'required|exists:clients,id',
                'selectedCar' => 'required|exists:cars,id',
                'selectedMat' => 'required|exists:matricules,id'
            ], [
                'selectedClient.required' => 'Please select a Client',
                'selectedCar.required' => 'Please select a Car',
                'selectedMat.required' => 'Please select a Matricule'
            ]);
        }
    }

    // ─────────────────────────────
    // 6. Custom Logic
    // ─────────────────────────────
    public function checkMatriculeAutoSelect()
    {
        if (!$this->selectedClient || !$this->selectedCar) return;

        $matricules = matricules::where('client_id', $this->selectedClient)
            ->where('car_id', $this->selectedCar)
            ->get();

        if ($matricules->count() === 1) {
            $this->selectedMat = $matricules->first()->id;
            $this->dispatch('auto-select-matricule', [
                'matriculeId' => $this->selectedMat,
                'matriculeName' => $matricules->first()->mat
            ]);
            Log::info('Auto-selected matricule: ' . $matricules->first()->mat);
        }
    }

    private function autoSelectCarAndMatricule()
    {
        $ownedCarIds = matricules::where('client_id', $this->selectedClient)
            ->pluck('car_id')
            ->unique()
            ->toArray();

        if (count($ownedCarIds) === 1) {
            $this->selectedCar = $ownedCarIds[0];
            $car = cars::find($this->selectedCar);

            $this->dispatch('auto-select-car', [
                'carId' => $this->selectedCar,
                'carName' => $car?->model ?? ''
            ]);

            $this->dispatch('$refresh');

            $matricules = matricules::where('client_id', $this->selectedClient)
                ->where('car_id', $this->selectedCar)
                ->get();

            if ($matricules->count() === 1) {
                $this->selectedMat = $matricules->first()->id;
                $this->dispatch('auto-select-matricule', [
                    'matriculeId' => $this->selectedMat,
                    'matriculeName' => $matricules->first()->mat
                ]);
            }
        }
    }

    public function createMatricule($matNumber)
    {
        $matricule = matricules::create([
            'client_id' => $this->selectedClient,
            'car_id'    => $this->selectedCar,
            'mat'       => $matNumber
        ]);

        $this->selectedMat = $matricule->id;

        $this->dispatch('matricule-created', [
            'id' => $matricule->id,
            'mat' => $matNumber
        ]);
    }

    // ─────────────────────────────
    // 7. Fetch Helpers
    // ─────────────────────────────
    public function fetchBrands()
    {
        $this->allbrands = brands::all();
    }

    public function fetchClients()
    {
        $this->allclients = clients::all();
    }

    public function fetchProduct()
    {
        $this->product = Products::all();
    }

    // ─────────────────────────────
    // 8. Submission
    // ─────────────────────────────
    public function submit()
    {
        $orderItems = json_decode($this->orderItems, true);

        if (empty($orderItems)) {
            session()->flash('error', 'No items in the order');
            return;
        }

        $processedOrderItems = array_map(fn($item) => [
            'product_id' => $item['id'] ?? null,
            'name' => $item['name'] ?? null,
            'description' => $item['description'] ?? null,
            'quantity' => $item['quantity'] ?? 0,
            'price' => $item['price'] ?? 0,
            'total' => ($item['quantity'] ?? 0) * ($item['price'] ?? 0)
        ], $orderItems);

        $totalAmount = collect($processedOrderItems)->sum('total') + $this->extraCharge - $this->discountAmount;

        $client = clients::findOrFail($this->selectedClient);
        $currentSold = (float)($client->sold ?? 0);

        if ($this->clientPaid > 0) {
            $remaining = $totalAmount - $this->clientPaid;
            if ($remaining > 0) {
                $client->sold = $currentSold + $remaining;
                $this->status = 'NOT PAID';
            } else {
                $client->sold = $currentSold - abs($remaining);
                $this->status = 'PAID';
            }
            $client->save();
        } else {
            $this->clientPaid = $totalAmount;
            $this->status = 'PAID';
        }

        $paidValue = $this->clientPaid ?: $totalAmount;

        Factures::create([
            'client_id' => $this->selectedClient,
            'car_id' => $this->selectedCar,
            'matricule_id' => $this->selectedMat,
            'km' => $this->km,
            'remark' => $this->remark,
            'order_items' => json_encode($processedOrderItems, JSON_THROW_ON_ERROR),
            'total_amount' => $totalAmount,
            'extra_charge' => $this->extraCharge,
            'discount_amount' => $this->discountAmount,
            'created_at' => now(),
            'updated_at' => now(),
            'status' => $this->status,
            'client_paid' => $this->clientPaid,
            'paid_value' => $paidValue,
        ]);
    }
}
