<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\MissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    protected $missionService;

    public function __construct(MissionService $missionService)
    {
        $this->missionService = $missionService;
    }

    /**
     * Récupère les missions en cours et terminées d'une école
     * GET /api/missions/ecole/{id}
     */
    public function getMissionsParEcole($id): JsonResponse
    {
        $result = $this->missionService->getMissionsParEcole($id);
        return response()->json($result);
    }

    /**
     * Crée une nouvelle mission
     * POST /api/missiondeclaration
     */
    public function creezdeclarationMission(Request $request): JsonResponse
{
    $request->validate([
        'titre' => 'required|string|max:255',
        'intervenant_id' => 'required|exists:intervenant,id_intervenant', // Corrigez le nom de table
        'ecole_id' => 'required|exists:ecole,id_ecole',
        'date_debut' => 'nullable|date', // Rendre optionnel
        'date_fin' => 'nullable|date|after_or_equal:date_debut',
        'duree' => 'nullable|integer|min:1',
        'descriptions_mission' => 'nullable|string',
        'conditions' => 'nullable|string'
    ]);

    $result = $this->missionService->creerMission($request->all());

    if ($result['success']) {
        return response()->json($result, 201);
    }

    return response()->json($result, 400);
}

    public function getAllMission(): JsonResponse
    {
        $result = $this->missionService->getAllMission();
        return response()->json($result);
    }
    public function getMissionsSansDates(): JsonResponse
    {
        $result = $this->missionService->checkDateisNull();
        return response()->json([
            'success' => true,
            'missions' => $result
        ]);
    }

    /**
     * Met à jour les dates d'une mission
     * PUT /api/missions/{id}/dates
     */
    public function updateDatesMission(Request $request, $id): JsonResponse
    {
        $request->validate([
            'date_debut' => 'required|date',
            'duree' => 'nullable|integer|min:1'
        ]);

        $result = $this->missionService->updateDatesMission(
            $id,
            $request->date_debut,
            $request->duree
        );

        if ($result['success']) {
            return response()->json($result, 200);
        }

        return response()->json($result, 400);
    }
}
