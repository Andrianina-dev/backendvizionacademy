<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IntervenantService;

class IntervenantController extends Controller
{
    protected $service;

    public function __construct(IntervenantService $service)
    {
        $this->service = $service;
    }

    


    public function index()
    {
        $intervenants = $this->service->getAllIntervenants();
        return response()->json(['success' => true, 'data' => $intervenants]);
    }

    public function show($id)
    {
        $intervenant = $this->service->getIntervenantById($id);
        if (!$intervenant) {
            return response()->json(['success' => false, 'message' => 'Intervenant non trouvé'], 404);
        }
        return response()->json(['success' => true, 'data' => $intervenant]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_intervenant' => 'required|string',
            'prenom_intervenant' => 'required|string',
            'email_login' => 'required|email|unique:intervenant,email_login',
            'mot_de_passe' => 'required|string',
            'photo_intervenant' => 'nullable|string',
            'bio_intervenant' => 'nullable|string',
            'diplome' => 'nullable|string',
            'cv' => 'nullable|string',
            'video' => 'nullable|string',
            'langues' => 'nullable|array',
            'domaines' => 'nullable|array',
            'ville' => 'nullable|string',
            'disponibilite' => 'nullable|integer',
        ]);

        $intervenant = $this->service->createIntervenant($data);

        return response()->json(['success' => true, 'data' => $intervenant], 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'nom_intervenant',
            'prenom_intervenant',
            'email_login',
            'mot_de_passe',
            'photo_intervenant',
            'bio_intervenant',
            'diplome',
            'cv',
            'video',
            'langues',
            'domaines',
            'ville',
            'disponibilite',
        ]);

        $intervenant = $this->service->updateIntervenant($id, $data);

        if (!$intervenant) {
            return response()->json(['success' => false, 'message' => 'Intervenant non trouvé'], 404);
        }

        return response()->json(['success' => true, 'data' => $intervenant]);
    }

    public function destroy($id)
    {
        $deleted = $this->service->deleteIntervenant($id);

        if (!$deleted) {
            return response()->json(['success' => false, 'message' => 'Intervenant non trouvé'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Intervenant supprimé']);
    }
     public function favorisConsultation($ecoleId)
    {
        $intervenants = $this->service->getFavoris($ecoleId);

        return response()->json([
            'data' => $intervenants
        ]);
    }

    /**
 * Récupère la liste des intervenants favoris pour une école donnée
 */
public function favoris($ecoleId)
{
    try {
        $intervenants = $this->service->getFavoris($ecoleId);

        return response()->json([
            'success' => true,
            'data' => $intervenants
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

}
