<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Cashbox;
use Illuminate\Support\Carbon;
use App\Models\Factures;
use App\Models\CaisseHistorique;


class EnsureDailyCashbox
{
    public function handle(Request $request, Closure $next)
    {
        // Only once per calendar day:
        // $today = Carbon::today();

        // // Only create if today's record is missing:
        // if (! Cashbox::whereDate('created_at', $today)->exists()) {
        //     $yesterdayBox = Cashbox::latest('created_at')->first();

        //     // Default to zero if there's literally no previous row:
        //     $newStart = 0;

        //     if ($yesterdayBox) {
        //         // If end_value is defined, use it
        //         if (! is_null($yesterdayBox->end_value)) {
        //             $newStart = $yesterdayBox->end_value;
        //         } else {
        //             // Otherwise compute it: start + total_in - total_out
        //             $date = $yesterdayBox->created_at->toDateString();

        //             $in  = Factures::whereDate('created_at', $date)
        //                            ->sum('total_amount');

        //             $out = CaisseHistorique::whereDate('created_at', $date)
        //                                    ->where('type', 'SORTIE')
        //                                    ->sum('montant');

        //             $newStart = $yesterdayBox->start_value + $in - $out;
        //         }
        //     }

        //     Cashbox::create([
        //         'start_value' => $newStart,
        //     ]);
        // }

        // return $next($request);

    }
}
