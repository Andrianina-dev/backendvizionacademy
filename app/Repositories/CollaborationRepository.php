<?php

namespace App\Repositories;

use App\Models\CollaborationIntervenant;
use Illuminate\Database\Eloquent\Collection;

class CollaborationRepository
{
    /**
     * 🔹 Récupère l'historique des collaborations pour l'école connectée
     */
    public function getByEcole(string $ecoleId): Collection
    {
        return CollaborationIntervenant::select(
                'mission_id',
                'intervenant_id',
                'ecole_id',
                'nom_ecole',
                'nom_intervenant',
                'prenom_intervenant',
                'titre_mission',
                'montant'
            )
            ->where('ecole_id', $ecoleId)
            ->orderBy('mission_id', 'desc')
            ->get();
    }
}
