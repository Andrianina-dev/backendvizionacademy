<?php

namespace App\Services;

use App\Repositories\FavorisRepository;
use App\Models\Intervenant;
use Illuminate\Support\Facades\Log;

class FavorisService
{
    protected $favorisRepository;

    public function __construct(FavorisRepository $favorisRepository)
    {
        $this->favorisRepository = $favorisRepository;
    }

    /**
     * 🔹 Récupérer les favoris d'une école
     */
    public function getFavoris(string $ecoleId): array
    {
        try {
            $favoris = $this->favorisRepository->getFavoris($ecoleId);
            $count = $favoris->count();

            return [
                'success' => true,
                'data' => $favoris,
                'count' => $count,
                'message' => $count > 0
                    ? 'Favoris récupérés avec succès.'
                    : 'Aucun favori trouvé.'
            ];
        } catch (\Throwable $e) {
            Log::error('Erreur getFavoris: ' . $e->getMessage());
            return [
                'success' => false,
                'data' => [],
                'count' => 0,
                'message' => 'Erreur lors de la récupération des favoris.'
            ];
        }
    }

    /**
     * 🔹 Récupérer les intervenants ayant collaboré avec l’école
     */
    public function getIntervenantsCollabores(string $ecoleId): array
    {
        try {
            $intervenants = $this->favorisRepository->getIntervenantsCollabores($ecoleId);
            $count = $intervenants->count();

            return [
                'success' => true,
                'data' => $intervenants,
                'count' => $count,
                'message' => $count > 0
                    ? 'Intervenants collaborés récupérés avec succès.'
                    : 'Aucun intervenant collaboré trouvé.'
            ];
        } catch (\Throwable $e) {
            Log::error('Erreur getIntervenantsCollabores: ' . $e->getMessage());
            return [
                'success' => false,
                'data' => [],
                'count' => 0,
                'message' => 'Erreur lors de la récupération des intervenants collaborés.'
            ];
        }
    }

    /**
     * 🔹 Récupérer les intervenants avec statut (favori + collaboration)
     */
    // public function getIntervenantsAvecStatut(string $ecoleId): array
    // {
    //     try {
    //         $intervenants = $this->favorisRepository->getIntervenantsAvecStatut($ecoleId);

    //         $intervenantsAvecStatut = $intervenants->map(function ($intervenant) use ($ecoleId) {
    //             return [
    //                 ...$intervenant->toArray(),
    //                 'is_favori' => $this->favorisRepository->isFavori($ecoleId, $intervenant->id_intervenant),
    //                 'has_collaborated' => $this->favorisRepository->hasCollaborated($ecoleId, $intervenant->id_intervenant),
    //                 'nom_complet' => trim($intervenant->prenom_intervenant . ' ' . $intervenant->nom_intervenant),
    //             ];
    //         });

    //         $count = $intervenantsAvecStatut->count();

    //         return [
    //             'success' => true,
    //             'data' => $intervenantsAvecStatut,
    //             'count' => $count,
    //             'message' => $count > 0
    //                 ? 'Intervenants récupérés avec succès.'
    //                 : 'Aucun intervenant trouvé.'
    //         ];
    //     } catch (\Throwable $e) {
    //         Log::error('Erreur getIntervenantsAvecStatut: ' . $e->getMessage());
    //         return [
    //             'success' => false,
    //             'data' => [],
    //             'count' => 0,
    //             'message' => 'Erreur lors de la récupération des intervenants.'
    //         ];
    //     }
    // }

    /**
     * 🔹 Ajouter un intervenant aux favoris
     */
    public function addFavori(string $ecoleId, string $intervenantId): array
    {
        try {
            if (!Intervenant::where('id_intervenant', $intervenantId)->exists()) {
                return [
                    'success' => false,
                    'message' => 'Intervenant non trouvé.'
                ];
            }

            // Éviter les doublons
            if ($this->favorisRepository->isFavori($ecoleId, $intervenantId)) {
                return [
                    'success' => false,
                    'message' => 'Cet intervenant est déjà dans les favoris.'
                ];
            }

            $favori = $this->favorisRepository->addFavori($ecoleId, $intervenantId);

            return [
                'success' => true,
                'data' => $favori,
                'message' => 'Intervenant ajouté aux favoris avec succès.'
            ];
        } catch (\Throwable $e) {
            Log::error('Erreur addFavori: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur lors de l’ajout aux favoris.'
            ];
        }
    }

    /**
     * 🔹 Supprimer un intervenant des favoris
     */
    public function removeFavori(string $ecoleId, string $intervenantId): array
    {
        try {
            if ($this->favorisRepository->removeFavori($ecoleId, $intervenantId)) {
                return [
                    'success' => true,
                    'message' => 'Intervenant retiré des favoris avec succès.'
                ];
            }

            return [
                'success' => false,
                'message' => 'Favori non trouvé.'
            ];
        } catch (\Throwable $e) {
            Log::error('Erreur removeFavori: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur lors de la suppression du favori.'
            ];
        }
    }

    /**
     * 🔹 Statistiques sur les favoris
     */
    public function getStatsFavoris(string $ecoleId): array
    {
        try {
            $stats = $this->favorisRepository->getStatsFavoris($ecoleId);

            return [
                'success' => true,
                'data' => $stats,
                'message' => 'Statistiques récupérées avec succès.'
            ];
        } catch (\Throwable $e) {
            Log::error('Erreur getStatsFavoris: ' . $e->getMessage());
            return [
                'success' => false,
                'data' => [
                    'total_favoris' => 0,
                    'intervenants_collabores' => 0,
                    'favoris_collabores' => 0,
                ],
                'message' => 'Erreur lors de la récupération des statistiques.'
            ];
        }
    }

    /**
     * 🔹 Vérifier si un intervenant est en favoris
     */
    public function isFavori(string $ecoleId, string $intervenantId): array
    {
        try {
            $isFavori = $this->favorisRepository->isFavori($ecoleId, $intervenantId);

            return [
                'success' => true,
                'data' => ['is_favori' => $isFavori],
                'message' => $isFavori
                    ? 'Intervenant est dans les favoris.'
                    : 'Intervenant n’est pas dans les favoris.'
            ];
        } catch (\Throwable $e) {
            Log::error('Erreur isFavori: ' . $e->getMessage());
            return [
                'success' => false,
                'data' => ['is_favori' => false],
                'message' => 'Erreur lors de la vérification du favori.'
            ];
        }
    }

    /**
     * 🔹 Vérifier si un intervenant a collaboré avec l’école
     */
    // public function hasCollaborated(string $ecoleId, string $intervenantId): array
    // {
    //     try {
    //         $hasCollaborated = $this->favorisRepository->hasCollaborated($ecoleId, $intervenantId);

    //         return [
    //             'success' => true,
    //             'data' => ['has_collaborated' => $hasCollaborated],
    //             'message' => $hasCollaborated
    //                 ? 'L’intervenant a collaboré avec cette école.'
    //                 : 'Aucune collaboration trouvée.'
    //         ];
    //     } catch (\Throwable $e) {
    //         Log::error('Erreur hasCollaborated: ' . $e->getMessage());
    //         return [
    //             'success' => false,
    //             'data' => ['has_collaborated' => false],
    //             'message' => 'Erreur lors de la vérification de la collaboration.'
    //         ];
    //     }
    // }
}
