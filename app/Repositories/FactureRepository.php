<?php

namespace App\Repositories;

use App\Models\Facture;
use Illuminate\Database\Eloquent\Collection;

class FactureRepository
{
    /**
     * Récupère UNIQUEMENT les factures de l'école connectée
     */
    public function getFacturesParEcole(string $ecoleId): Collection
    {
        return Facture::select(
                'id_facture',
                'mission_id',
                'intervenant_id',
                'ecole_id',
                'nom_ecole',
                'titre_mission',
                'montant',
                'date_creation',
                'date_paiement',
                'statut'
            )
            ->where('ecole_id', $ecoleId) // ← Seulement les factures de cette école
            ->orderBy('date_creation', 'desc')
            ->get();
    }
}
