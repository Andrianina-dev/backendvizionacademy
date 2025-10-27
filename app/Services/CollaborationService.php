<?php

namespace App\Services;

use App\Repositories\CollaborationRepository;
use Illuminate\Database\Eloquent\Collection;

class CollaborationService
{
    protected $collaborationRepository;

    public function __construct(CollaborationRepository $collaborationRepository)
    {
        $this->collaborationRepository = $collaborationRepository;
    }

    public function getByEcole(string $ecoleId): Collection
    {
        return $this->collaborationRepository->getByEcole($ecoleId);
    }
}
