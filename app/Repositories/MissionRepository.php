<?php

namespace App\Repositories;

use App\Models\MissionAvecEtat;
use App\Models\Mission;
use Illuminate\Support\Facades\Log;

class MissionRepository
{
    /**
     * Récupère les missions EN COURS et TERMINÉES d'une école spécifique
     */
    public function getMissionsParEcole(string $ecoleId)
    {
        try {
            $missions = MissionAvecEtat::where('ecole_id', $ecoleId)
                ->whereIn('etat_mission', ['en cours', 'terminée'])
                ->orderBy('date_debut', 'desc')
                ->get();

            if ($missions->isEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Aucune mission en cours ou terminée trouvée pour cette école',
                    'missions' => [],
                    'count' => 0
                ];
            }

            return [
                'success' => true,
                'message' => 'Missions récupérées avec succès',
                'missions' => $missions,
                'count' => $missions->count()
            ];

        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des missions', [
                'ecole_id' => $ecoleId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Erreur lors de la récupération des missions',
                'missions' => [],
                'count' => 0
            ];
        }
    }

    /**
     * Crée une nouvelle mission pour l'école connectée
     */
    /**
 * Crée une nouvelle mission pour l'école connectée
 */
/**
 * Crée une nouvelle mission pour l'école connectée
 */
public function creerMission(array $data)
{
    try {
        // Validation des champs requis
        if (empty($data['titre']) || empty($data['intervenant_id']) || empty($data['ecole_id'])) {
            return [
                'success' => false,
                'message' => 'Les champs titre, intervenant_id et ecole_id sont obligatoires',
                'mission' => null
            ];
        }

        // Gestion des dates et durée - CORRIGÉ
        $dateDebut = null;
        $dateFin = null;
        $duree = $data['duree'] ?? 1;

        // Si date_debut et date_fin sont fournis
        if (!empty($data['date_debut']) && !empty($data['date_fin'])) {
            $dateDebut = new \DateTime($data['date_debut']);
            $dateFin = new \DateTime($data['date_fin']);

            // Calcul de la durée en jours
            $interval = $dateDebut->diff($dateFin);
            $duree = max($interval->days - 1, 1); // +1 pour inclure le jour de début
        }
        // Si seulement date_debut est fourni avec durée
        elseif (!empty($data['date_debut']) && !empty($duree)) {
            $dateDebut = new \DateTime($data['date_debut']);
            $dateFin = (clone $dateDebut)->modify('+' . ($duree - 1) . ' days');
        }
        // Si seulement la durée est fournie SANS dates → GARDER null
        elseif (!empty($duree)) {
            // Ne pas générer de dates automatiquement, garder null
            $dateDebut = null;
            $dateFin = null;
        }

        // Création de la mission - RESPECTER les nulls
        $missionData = [
            'titre' => $data['titre'],
            'descriptions_mission' => $data['descriptions_mission'] ?? null,
            'intervenant_id' => $data['intervenant_id'],
            'ecole_id' => $data['ecole_id'],
            'date_debut' => $dateDebut ? $dateDebut->format('Y-m-d H:i:s') : null, // Rester null si pas de date
            'date_fin' => $dateFin ? $dateFin->format('Y-m-d H:i:s') : null,       // Rester null si pas de date
            'duree' => $duree,
            'conditions' => $data['conditions'] ?? null,
            'date_creation' => now(),
        ];

        $mission = Mission::create($missionData);

        return [
            'success' => true,
            'message' => 'Mission créée avec succès',
            'mission' => $mission
        ];

    } catch (\Exception $e) {
        Log::error('Erreur lors de la création de la mission', [
            'data' => $data,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return [
            'success' => false,
            'message' => 'Erreur lors de la création de la mission: ' . $e->getMessage(),
            'mission' => null
        ];
    }
}
    public function checkDateisNull()
    {
        return Mission::whereNull('date_debut')
                    ->whereNull('date_fin')
                    ->get(['id_mission', 'titre', 'duree', 'date_creation']);
    }

public function updateDatesMission($idMission, $dateDebut, $duree = null)
{
    try {
        // APPELER la fonction checkDateisNull pour vérifier
        $missionsSansDates = $this->checkDateisNull();

        // Vérifier si l'ID existe dans la liste des missions sans dates
        $missionTrouvee = $missionsSansDates->first(function ($mission) use ($idMission) {
            return $mission->id_mission === $idMission;
        });

        if (!$missionTrouvee) {
            return [
                'success' => false,
                'message' => 'Mission non trouvée ou a déjà des dates définies'
            ];
        }

        // Récupérer la mission complète pour la mise à jour
        $mission = Mission::where('id_mission', $idMission)->first();

        // Logique de mise à jour
        if ($dateDebut && !$duree) {
            $debut = new \DateTime($dateDebut);
            $fin = (clone $debut)->modify('+' . ($mission->duree - 1) . ' days');

            $mission->date_debut = $debut->format('Y-m-d H:i:s');
            $mission->date_fin = $fin->format('Y-m-d H:i:s');
        }
        // Si date_debut et nouvelle durée sont fournies
        elseif ($dateDebut && $duree) {
            $debut = new \DateTime($dateDebut);
            $fin = (clone $debut)->modify('+' . ($duree - 1) . ' days');

            $mission->date_debut = $debut->format('Y-m-d H:i:s');
            $mission->date_fin = $fin->format('Y-m-d H:i:s');
            $mission->duree = $duree;
        }

        $mission->save();

        return [
            'success' => true,
            'message' => 'Dates de mission mises à jour avec succès',
            'mission' => $mission
        ];

    } catch (\Exception $e) {
        Log::error('Erreur lors de la mise à jour des dates de mission', [
            'id_mission' => $idMission,
            'error' => $e->getMessage()
        ]);

        return [
            'success' => false,
            'message' => 'Erreur lors de la mise à jour des dates: ' . $e->getMessage()
        ];
    }
}
public function getAllMission()
{
    $missions = Mission::all();

    return [
        'success' => true,
        'message' => 'Toutes les missions récupérées avec succès',
        'missions' => $missions,
        'count' => $missions->count()
    ];
}
}
