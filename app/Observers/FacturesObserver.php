<?php

namespace App\Observers;

use App\Models\Factures;
use App\Models\Cashbox;

class FacturesObserver
{
    /**
     * Handle the Factures "created" event.
     */
    public function created(Factures $facture): void
    {
        Cashbox::whereDate('created_at', $facture->created_at->toDateString())
               ->increment('end_value', $facture->total_amount);
    }

    /**
     * Handle the Factures "updated" event.
     */
    public function updated(Factures $facture): void
    {
        $original = $facture->getOriginal('total_amount');
        $diff     = $facture->total_amount - $original;

        if ($diff !== 0) {
            Cashbox::whereDate('created_at', $facture->created_at->toDateString())
                   ->increment('end_value', $diff);
        }
        
        
    }

    /**
     * Handle the Factures "deleted" event.
     */
    public function deleted(Factures $facture): void
    {
        Cashbox::whereDate('created_at', $facture->created_at->toDateString())
        ->decrement('end_value', $facture->total_amount);

        // Lookup the related client
        $client = $facture->client;
        if (! $client) {
            return;
        }

        // Compute how much debt this facture represents:
        //   total_amount minus whatever was already paid.
        $paid      = (float) ($facture->paid_value ?? 0);
        $total     = (float) $facture->total_amount;
        $remaining = max(0, $total - $paid);

        // Subtract that from client's sold (debt)
        // (guard to not go negative if you prefer)
        $client->sold = max(0, $client->sold - $remaining);
        $client->save();
    }

    /**
     * Handle the Factures "restored" event.
     */
    public function restored(Factures $facture): void
    {
        //
    }

    /**
     * Handle the Factures "force deleted" event.
     */
    public function forceDeleted(Factures $facture): void
    {
        //
    }
}
