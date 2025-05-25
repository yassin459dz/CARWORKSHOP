<?php

namespace App\Livewire;

use App\Models\Factures;
use App\Models\clients;
use Livewire\Component;

class ViewFacture extends Component
{
    public $factureId;
    public $facture;
    public $invoiceNumber;
    public $date;
    public $time;
    public $status;
    public $client;
    public $phone;
    public $phone2;
    public $address;
    public $vehicle;
    public $orderItems = [];
    public $financial;
    public $remark;


    public function mount($id)
    {
        $this->factureId = $id;
        $this->loadFacture();
    }

    protected function loadFacture()
    {
        $this->facture = Factures::with(['client', 'car', 'matricule'])->findOrFail($this->factureId);

        // If you want to debug, uncomment these lines:
        // dd($this->facture->getAttributes()['order_items']); // Raw value from DB
        // dd($this->facture->order_items); // After cast

        // Set invoice details
        $this->invoiceNumber = str_pad($this->facture->id, 6, '0', STR_PAD_LEFT);
        $this->date = $this->facture->created_at->format('d-M-Y');
        $this->time = $this->facture->created_at->format('g:i A');

        // Set client info
        $this->client = [
            'name' => $this->facture->client->name,
            'phone' => $this->facture->client->phone,
            'sold' => $this->facture->client->sold,
            'phone2' => $this->facture->client->phone2,
            'address' => $this->facture->client->address,


        ];

        // Set vehicle info
        $this->vehicle = [
            'model' => $this->facture->car->model,
            'matricule' => $this->facture->matricule->mat,
            'kilometers' => $this->facture->km
        ];

        // Handle order items - ensure it's an array
        $this->orderItems = is_array($this->facture->order_items)
            ? $this->facture->order_items
            : json_decode($this->facture->order_items, true) ?? [];

        // Set financial details
        $this->financial = [
            'total_amount' => $this->facture->total_amount,
            'extra_charge' => $this->facture->extra_charge ?? 0,
            'discount_amount' => $this->facture->discount_amount ?? 0,

        ];
        $this->remark = $this->facture->remark;
        $this->status = $this->facture->status;

    }

    public function print()
    {
        $previewData = [
            'invoiceNumber' => $this->invoiceNumber,
            'date' => $this->date,
            'time' => $this->time,
            'status' => $this->status,
            'client' => $this->client,
            'vehicle' => $this->vehicle,
            'orderItems' => $this->orderItems,
            'financial' => $this->financial,
            'remark' => $this->remark
        ];

        $this->dispatch('show-thermal-invoice-preview', $previewData);
    }

    public function render()
    {
        return view('livewire.Facture.view-facture');
    }
}
