<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use App\Models\Cashbox;
use Illuminate\Support\Facades\Log;
use App\Models\Factures;
use App\Models\CaisseHistorique;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Observers\CaisseHistoriqueObserver;
use App\Observers\FacturesObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       // register observers
       CaisseHistorique::observe(\App\Observers\CaisseHistoriqueObserver::class);
       Factures::observe(\App\Observers\FacturesObserver::class);

       // Only on real web requests:
       if (! app()->runningInConsole()) {
           $today = Carbon::today();

           // if today's cashbox is missing, create it
           if (! Cashbox::whereDate('created_at', $today)->exists()) {
               $yesterday = Cashbox::latest('created_at')->first();
               $seed = 0;

               if ($yesterday) {
                   // 1) prefer yesterday’s system end_value
                   if (! is_null($yesterday->end_value)) {
                       $seed = $yesterday->end_value;
                   }
                   // 2) or else recompute it from start + invoices – outflows
                   else {
                       $d   = $yesterday->created_at->toDateString();
                       $in  = Factures::whereDate('created_at', $d)->sum('total_amount');
                       $out = CaisseHistorique::whereDate('created_at', $d)->sum('montant');
                       $seed = $yesterday->start_value + $in - $out;
                   }
               }

               Cashbox::create([
                   'start_value'      => $seed,
                   'end_value'        => $seed,
                   // manual_end_value/Set purely for audit, never seeds tomorrow
                   'manual_end_value' => null,
                   'manual_end_set'   => false,
               ]);

               Log::info(sprintf(
                   '[Bootstrap Cashbox] created for %s with start/end = %.2f',
                   $today->toDateString(),
                   $seed
               ));
           }
       }
    }

}
