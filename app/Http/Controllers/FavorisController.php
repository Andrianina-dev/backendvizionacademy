<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\FavorisService;
use Illuminate\Http\Request;

class FavorisController extends Controller
{
    protected $favorisService;

    public function __construct(FavorisService $favorisService)
    {
        $this->favorisService = $favorisService;
    }

    /**
     * 📌 Récupère tous les intervenants favoris d'une école
     */
    public function getFavoris(string $ecoleId)
    {
        $result = $this->favorisService->getFavoris($ecoleId);
        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * 📌 Récupère les intervenants ayant déjà collaboré avec une école
     */
    public function getIntervenantsCollabores(string $ecoleId)
    {
        $result = $this->favorisService->getIntervenantsCollabores($ecoleId);
        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * 📌 Ajoute un intervenant aux favoris
     */
    public function addFavori(Request $request)
    {
        $validated = $request->validate([
            'ecole_id' => 'required|string|exists:ecole,id_ecole',
            'intervenant_id' => 'required|string|exists:intervenant,id_intervenant',
        ]);

        $result = $this->favorisService->addFavori(
            $validated['ecole_id'],
            $validated['intervenant_id']
        );

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * 📌 Supprime un intervenant des favoris
     */
    public function removeFavori(Request $request)
    {
        $validated = $request->validate([
            'ecole_id' => 'required|string|exists:ecole,id_ecole',
            'intervenant_id' => 'required|string|exists:intervenant,id_intervenant',
        ]);

        $result = $this->favorisService->removeFavori(
            $validated['ecole_id'],
            $validated['intervenant_id']
        );

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * 📌 Vérifie si un intervenant est déjà en favoris
     */
    public function isFavori(string $ecoleId, string $intervenantId)
    {
        $result = $this->favorisService->isFavori($ecoleId, $intervenantId);
        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * 📌 Vérifie si un intervenant a déjà collaboré avec une école
     */
    // public function hasCollaborated(string $ecoleId, string $intervenantId)
    // {
    //     $result = $this->favorisService->hasCollaborated($ecoleId, $intervenantId);
    //     return response()->json($result, $result['success'] ? 200 : 400);
    // }

    /**
     * 📊 Récupère les statistiques sur les favoris
     */
    public function getStats(string $ecoleId)
    {
        $result = $this->favorisService->getStatsFavoris($ecoleId);
        return response()->json($result, $result['success'] ? 200 : 400);
    }
}
