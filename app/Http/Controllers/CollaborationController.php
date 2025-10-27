<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CollaborationService;
use Illuminate\Http\JsonResponse;

class CollaborationController extends Controller
{
    protected $collaborationService;

    public function __construct(CollaborationService $collaborationService)
    {
        $this->collaborationService = $collaborationService;
    }

    public function byEcole(string $id): JsonResponse
    {
        $collaborations = $this->collaborationService->getByEcole($id);
        return response()->json(['success' => true, 'data' => $collaborations]);
    }
}
