<?php

namespace App\Observers;

use App\Models\Cashbox;
use Illuminate\Support\Carbon;

class CashboxObserver
{
    /**
     * Handle the Cashbox "created" event.
     */
    public function created(Cashbox $cashbox): void
    {

}

    /**
     * Handle the Cashbox "updated" event.
     */
    public function updated(Cashbox $cashbox): void
    {
                       // Only act if end_value really changed
       if ($cashbox->wasChanged('end_value')) {
        $newEnd = $cashbox->end_value;

        // Compute next day's date
        $nextDate = Carbon::parse($cashbox->created_at)
                          ->addDay()
                          ->toDateString();

        // Try to find tomorrow's box
        $tomorrow = Cashbox::whereDate('created_at', $nextDate)->first();

        if ($tomorrow) {
            // Overwrite its start_value
            $tomorrow->update(['start_value' => $newEnd]);
        }
    }
    }

    /**
     * Handle the Cashbox "deleted" event.
     */
    public function deleted(Cashbox $cashbox): void
    {

    }

    /**
     * Handle the Cashbox "restored" event.
     */
    public function restored(Cashbox $cashbox): void
    {
        //
    }

    /**
     * Handle the Cashbox "force deleted" event.
     */
    public function forceDeleted(Cashbox $cashbox): void
    {
        //
    }
}
