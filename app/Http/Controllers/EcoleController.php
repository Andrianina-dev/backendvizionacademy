<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\EcoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EcoleController extends Controller
{
    protected $ecoleService;

    public function __construct(EcoleService $ecoleService)
    {
        $this->ecoleService = $ecoleService;
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email', // Validation pour email
            'mot_de_passe' => 'required|string'
        ]);

        $result = $this->ecoleService->loginEcole(
            $request->email, // Utiliser email au lieu de id_ecole
            $request->mot_de_passe
        );

        if ($result['success']) {
            // Stocker l'école en session
            session(['ecole_connectee' => $result['ecole']]);

            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'ecole' => $result['ecole'] // Contient l'id_ecole
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message']
        ], 401);
    }

    public function logout(): JsonResponse
    {
        session()->forget('ecole_connectee');

        return response()->json([
            'success' => true,
            'message' => 'Déconnexion réussie'
        ]);
    }

    public function getEcoleConnectee(): JsonResponse
    {
        $ecole = session('ecole_connectee');

        if ($ecole) {
            return response()->json([
                'success' => true,
                'ecole' => $ecole
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Aucune école connectée'
        ], 401);
    }
}
