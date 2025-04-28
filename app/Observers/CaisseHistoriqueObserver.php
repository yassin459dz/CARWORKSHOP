<?php

namespace App\Observers;

use App\Models\CaisseHistorique;
use App\Models\Cashbox;

class CaisseHistoriqueObserver
{
    /**
     * Compute the signed delta for a movement:
     *   - If it's an 'ENTREE', it's positive.
     *   - Otherwise (SORTIE, DEPENSE, or NULL), it's negative.
     */
    protected function delta(CaisseHistorique $mvt): float
    {
        return $mvt->type === 'ENTREE'
             ?  $mvt->montant
             : -$mvt->montant;
    }

    /**
     * When a movement is created, bump end_value by its delta.
     */
    public function created(CaisseHistorique $mvt): void
    {
        Cashbox::whereDate('created_at', $mvt->created_at->toDateString())
               ->increment('end_value', $this->delta($mvt));
    }

    /**
     * When a movement is updated, apply the change in delta.
     */
    public function updated(CaisseHistorique $mvt): void
    {
        $origAmt  = $mvt->getOriginal('montant');
        $origType = $mvt->getOriginal('type');

        // old delta (before update)
        $oldDelta = ($origType === 'ENTREE') ? $origAmt : -$origAmt;
        // new delta (after update)
        $newDelta = $this->delta($mvt);

        $diff = $newDelta - $oldDelta;
        if ($diff !== 0) {
            Cashbox::whereDate('created_at', $mvt->created_at->toDateString())
                   ->increment('end_value', $diff);
        }
    }

    /**
     * When a movement is deleted, reverse its delta.
     */
    public function deleted(CaisseHistorique $mvt): void
    {
        Cashbox::whereDate('created_at', $mvt->created_at->toDateString())
               ->increment('end_value', -1 * $this->delta($mvt));
    }
}
