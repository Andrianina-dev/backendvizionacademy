<?php

namespace App\Repositories;

use App\Models\FavorisIntervenant;
use App\Models\Intervenant;
use App\Models\Mission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class FavorisRepository
{
    protected $favorisModel;
    protected $intervenantModel;
    protected $missionModel;

    public function __construct(
        FavorisIntervenant $favorisModel,
        Intervenant $intervenantModel,
        Mission $missionModel
    ) {
        $this->favorisModel = $favorisModel;
        $this->intervenantModel = $intervenantModel;
        $this->missionModel = $missionModel;
    }

    /**
     * 🔹 Récupérer tous les favoris d'une école
     */
    public function getFavoris(string $ecoleId): Collection
    {
        return $this->favorisModel
            ->with('intervenant') // pour charger les infos de l’intervenant lié
            ->where('ecole_id', $ecoleId)
            ->get();
    }

    /**
     * 🔹 Ajouter un intervenant aux favoris
     */
    public function addFavori(string $ecoleId, string $intervenantId): FavorisIntervenant
    {
        $existing = $this->favorisModel
            ->where('ecole_id', $ecoleId)
            ->where('intervenant_id', $intervenantId)
            ->first();

        if ($existing) {
            Log::info('ℹ️ Favori déjà existant', [
                'ecole_id' => $ecoleId,
                'intervenant_id' => $intervenantId
            ]);
            return $existing;
        }

        return $this->favorisModel->create([
            'ecole_id' => $ecoleId,
            'intervenant_id' => $intervenantId,
            'date_ajout' => now(),
        ]);
    }

    /**
     * 🔹 Supprimer un intervenant des favoris
     */
    public function removeFavori(string $ecoleId, string $intervenantId): bool
    {
        return $this->favorisModel
            ->where('ecole_id', $ecoleId)
            ->where('intervenant_id', $intervenantId)
            ->delete() > 0;
    }

    /**
     * 🔹 Vérifier si un intervenant est déjà favori
     */
    public function isFavori(string $ecoleId, string $intervenantId): bool
    {
        return $this->favorisModel
            ->where('ecole_id', $ecoleId)
            ->where('intervenant_id', $intervenantId)
            ->exists();
    }

    /**
     * 🔹 Récupérer les intervenants ayant collaboré avec l'école
     */
    public function getIntervenantsCollabores(string $ecoleId): Collection
    {
        return $this->intervenantModel
            ->whereHas('missions', function ($query) use ($ecoleId) {
                $query->where('ecole_id', $ecoleId);
            })
            ->with(['missions' => function ($query) use ($ecoleId) {
                $query->where('ecole_id', $ecoleId);
            }])
            ->get();
    }

    /**
     * 🔹 Récupérer les intervenants avec leur statut (favori / collaboré)
     */
    public function getIntervenantsAvecStatut(string $ecoleId): Collection
    {
        $favorisIds = $this->favorisModel
            ->where('ecole_id', $ecoleId)
            ->pluck('intervenant_id')
            ->toArray();

        $collaboresIds = $this->missionModel
            ->where('ecole_id', $ecoleId)
            ->whereNotNull('intervenant_id')
            ->distinct()
            ->pluck('intervenant_id')
            ->toArray();

        $allIds = array_unique(array_merge($favorisIds, $collaboresIds));

        $intervenants = $this->intervenantModel
            ->whereIn('id_intervenant', $allIds)
            ->with(['missions' => function ($query) use ($ecoleId) {
                $query->where('ecole_id', $ecoleId);
            }])
            ->get();

        return $intervenants->map(function ($intervenant) use ($ecoleId, $favorisIds, $collaboresIds) {
            $intervenant->isFavori = in_array($intervenant->id_intervenant, $favorisIds);
            $intervenant->hasCollaborated = in_array($intervenant->id_intervenant, $collaboresIds);
            return $intervenant;
        });
    }

    /**
     * 🔹 Statistiques des favoris
     */
    public function getStatsFavoris(string $ecoleId): array
    {
        $totalFavoris = $this->favorisModel->where('ecole_id', $ecoleId)->count();

        $intervenantsCollabores = $this->missionModel
            ->where('ecole_id', $ecoleId)
            ->whereNotNull('intervenant_id')
            ->distinct()
            ->count('intervenant_id');

        $favorisCollabores = $this->favorisModel
            ->where('ecole_id', $ecoleId)
            ->whereIn('intervenant_id', function ($query) use ($ecoleId) {
                $query->select('intervenant_id')
                    ->from('mission')
                    ->where('ecole_id', $ecoleId)
                    ->whereNotNull('intervenant_id');
            })
            ->count();

        return [
            'total_favoris' => $totalFavoris,
            'intervenants_collabores' => $intervenantsCollabores,
            'favoris_collabores' => $favorisCollabores
        ];
    }
}