<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\FactureService;
use Illuminate\Http\JsonResponse;

class FactureController extends Controller
{
    protected $factureService;

    public function __construct(FactureService $factureService)
    {
        $this->factureService = $factureService;
    }

    public function getFacturesParEcole(string $ecoleId): JsonResponse
    {
        $factures = $this->factureService->getFacturesParEcole($ecoleId);
        return response()->json(['success' => true, 'data' => $factures]);
    }
}
