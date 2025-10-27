<?php

namespace App\Services;

use App\Repositories\MissionRepository;

class MissionService
{
    protected $missionRepository;

    public function __construct(MissionRepository $missionRepository)
    {
        $this->missionRepository = $missionRepository;
    }

    /**
     * Récupère les missions en cours et terminées pour une école
     */
    public function getMissionsParEcole(string $ecoleId)
    {
        return $this->missionRepository->getMissionsParEcole($ecoleId);
    }
     public function getAllMission()
    {
        return $this->missionRepository->getAllMission();
    }

    /**
     * Crée une nouvelle mission
     */
    public function creerMission(array $data)
    {
        return $this->missionRepository->creerMission($data);
    }

   public function checkDateisNull()
    {
        return $this->missionRepository->checkDateisNull();
    }

    /**
     * Met à jour les dates d'une mission
     */
    public function updateDatesMission($idMission, $dateDebut, $duree = null)
    {
        return $this->missionRepository->updateDatesMission($idMission, $dateDebut, $duree);
    }
}
