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


class Facture extends Component
{
    public $clientPaid = 0;
    public $status = 'NOT PAID';
    public $currentstep = 1;
    public $totalstep = 3;

    public $client_id;
    public $email;
    public $phone;
    public $fac;
    public $gender;
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

    public $orderItems = '[]';
    public $total_amount = 0;
    public $extraCharge = 0;
    public $discountAmount = 0;
    public $selectedClient = null;
    public $selectedMat = null;
    public $selectedCar = null;
    public $previousCarSelection = null; // Track previous car selection


    public function render()
    {

        $groupedCars = $this->getGroupedCarsProperty();
        return view('livewire.Facture.facture', compact('groupedCars'));    }

    public function mount()
    {
        $this->product = Products::all();
        // $this->allmat = collect();

        //  $this->allmat = matricules::all();

        $this->fetchClients();
        $this->allcars = collect();
        $this->allcars = cars::all();
        // Initialize payment properties
        $this->status = 'NOT PAID';
        $this->clientPaid = 0;
    }
    public function updatedSelectedMat($value)
    {
        if (!$value) {
            $this->mat = '';
        }
    }
    #[Computed()]
    public function getGroupedCarsProperty(): array
    {
        // Get IDs of cars associated with the selected client, if any.
        $ownedCarIds = $this->selectedClient
            ? matricules::where('client_id', $this->selectedClient)
                ->pluck('car_id')
                ->toArray()
            : [];

        // Filter the complete list into two groups.
        $ownedCars = $this->allcars->filter(function ($car) use ($ownedCarIds) {
            return in_array($car->id, $ownedCarIds);
        });

        $nonOwnedCars = $this->allcars->filter(function ($car) use ($ownedCarIds) {
            return !in_array($car->id, $ownedCarIds);
        });

        return [
            'Owned Car'     => $ownedCars,
            'Non Owned Car' => $nonOwnedCars,
        ];
    }

    public function updated($property, $value)
    {
        if (in_array($property, ['selectedClient', 'selectedCar'])) {
            // Reset selected mat when client or car changes
            $this->selectedMat = null;

            // Auto-select if only one matricule exists
            if ($this->filteredMatricules->count() === 1) {
                $this->selectedMat = $this->filteredMatricules->first()->id;
            }
        }
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


// public function createMatricule($matNumber)
// {


//     $matricule = Matricules::create([
//         'client_id' => $this->selectedClient,
//         'car_id'    => $this->selectedCar,
//         'mat'       => $matNumber
//     ]);

//     $this->selectedMat = $matricule->id;
//     $this->mat         = $matNumber;

// }
public function createMatricule($matNumber)
{
    $matricule = Matricules::create([
        'client_id' => $this->selectedClient,
        'car_id'    => $this->selectedCar,
        'mat'       => $matNumber
    ]);

    // $this->selectedMat = $matricule->id;
    // $this->mat         = $matNumber;

    // Emit event with car info
    // $this->dispatch('car-restored', id: $this->selectedCar);
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








    public function fetchBrands()
    {
        $this->allbrands = brands::all();
    }

    public function fetchClients()
    {
        $this->allclients = clients::all();
    }

    // public function fetchCars()
    // {
    //     $this->allcars = cars::all();
    // }

    public function fetchProduct()
    {
        $this->product = Products::all();
    }

    public function boot()
    {
        $this->allclients = clients::all();
        $this->allbrands = brands::all();
        // $this->allcars = cars::all();
        // $this->allmat = matricules::all();
        $this->product = Products::all();

        if ($this->client_id) {
            $selectedClient = $this->allclients->where('id', $this->client_id)->first();
            if ($selectedClient) {
                $this->search = $selectedClient->name;
            }
        }

        // if ($this->car_id) {
        //     $selectedCar = $this->allcars->where('id', $this->car_id)->first();
        //     if ($selectedCar) {
        //         $this->search = $selectedCar->Model;
        //     }
        // }

        if ($this->mat_id) {
            $selectedMatricule = $this->allmat->where('id', $this->mat_id)->first();
            if ($selectedMatricule) {
                $this->mat = $selectedMatricule->mat;
            }
        }
    }






    public function submit()
    {
        $orderItems = json_decode($this->orderItems, true);

        if (empty($orderItems)) {
            session()->flash('error', 'No items in the order');
            return;
        }

        $processedOrderItems = array_map(function($item) {
            return [
                'product_id' => $item['id'] ?? null,
                'name' => $item['name'] ?? null,
                'description' => $item['description'] ?? null,
                'quantity' => $item['quantity'] ?? 0,
                'price' => $item['price'] ?? 0,
                'total' => ($item['quantity'] ?? 0) * ($item['price'] ?? 0)
            ];
        }, $orderItems);

        $totalAmount = collect($processedOrderItems)->sum('total') + $this->extraCharge - $this->discountAmount;

        // Only update client sold if the payment checkbox was checked (clientPaid > 0)
        if ($this->clientPaid > 0) {
            $remaining = $totalAmount - $this->clientPaid;
            // If there's a remaining amount to be paid, update sold
            if ($remaining > 0) {
                $client = clients::findOrFail($this->selectedClient);
                $currentSold = (float)($client->sold ?? 0);
                $client->sold = $currentSold + $remaining;
                $client->save();
                Log::info("Client {$client->name} has a remaining balance of {$client->sold}");
                $this->status = 'NOT PAID';
            } else {
                $this->status = 'PAID';
            }
        } else {
            // Do not touch client sold
            $this->status = 'NOT PAID';
        }

        // Determine paid_value: always set to what the client actually paid
        $paidValue = 0;
        if ($this->clientPaid > 0) {
            $remaining = $totalAmount - $this->clientPaid;
            $paidValue = $this->clientPaid;
        }


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
