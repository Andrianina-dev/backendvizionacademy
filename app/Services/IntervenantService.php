<?php

namespace App\Services;

use App\Repositories\IntervenantRepository;

class IntervenantService
{
    protected $repository;

    public function __construct(IntervenantRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllIntervenants()
    {
        return $this->repository->getAll();
    }

    public function getIntervenantById(string $id)
    {
        return $this->repository->getById($id);
    }

    public function createIntervenant(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateIntervenant(string $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteIntervenant(string $id)
    {
        return $this->repository->delete($id);
    }
     public function getFavoris($ecoleId)
    {
        return $this->repository->favorisParEcole($ecoleId);
    }
}