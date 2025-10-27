<?php

namespace App\Services;

use App\Repositories\FactureRepository;
use Illuminate\Database\Eloquent\Collection;

class FactureService
{
    protected $factureRepository;

    public function __construct(FactureRepository $factureRepository)
    {
        $this->factureRepository = $factureRepository;
    }

    public function getFacturesParEcole(string $ecoleId): Collection
    {
        return $this->factureRepository->getFacturesParEcole($ecoleId);
    }
}
