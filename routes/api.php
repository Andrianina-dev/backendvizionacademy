<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EcoleController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\IntervenantController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\CollaborationController;
use App\Http\Controllers\FavorisController;

// ---------------------------
// Routes École
// ---------------------------

    Route::post('/ecole/login', [EcoleController::class, 'login']); // Utilise AuthController au lieu de EcoleController
    Route::post('/logout', [EcoleController::class, 'logout']);
    Route::get('/ecole-connectee', [EcoleController::class, 'getEcoleConnectee']);

// // ---------------------------
// // Routes Missions
// ---------------------------
Route::get('/mission/ecole/{id}', [MissionController::class, 'getMissionsParEcole']);
    Route::get('/', [MissionController::class, 'getMissionpasseencours']);
    Route::post('/declaration/mission/ecole', [MissionController::class, 'creezdeclarationMission']);
    Route::get('/missions/all', [MissionController::class, 'getAllMission']);

// // ---------------------------
// // Routes Factur
Route::get('/factures/ecole/{ecoleId}', [FactureController::class, 'getFacturesParEcole']);

// ---------------------------
// Routes Collaborations
// ---------------------------
Route::get('/collaborations/intervenant/ecole/{id}', [CollaborationController::class, 'byEcole']);

// ---------------------------
// Routes Intervenants
// ---------------------------

Route::get('/intervenants', [IntervenantController::class, 'index']);
Route::get('/intervenants/{id}', [IntervenantController::class, 'show']);
Route::post('/intervenants', [IntervenantController::class, 'store']);
Route::put('/intervenants/{id}', [IntervenantController::class, 'update']);
Route::delete('/intervenants/{id}', [IntervenantController::class, 'destroy']);
Route::get('intervenants/favoris/{ecoleId}', [IntervenantController::class, 'favoris']);

// Route::prefix('intervenants/favoris')->group(function () {
//     Route::get('/{ecoleId}', [FavorisController::class, 'getFavoris']);
//     Route::get('/collabores/{ecoleId}', [FavorisController::class, 'getIntervenantsCollabores']);
//     Route::post('/add', [FavorisController::class, 'addFavori']);
//     Route::delete('/remove', [FavorisController::class, 'removeFavori']);
//     Route::get('/stats/{ecoleId}', [FavorisController::class, 'getStats']);
//     // Route::get('/is-favori/{ecoleId}/{intervenantId}', [FavorisController::class, 'isFavori']);
//     // Route::get('/has-collabore/{ecoleId}/{intervenantId}', [FavorisController::class, 'hasCollaborated']);
// });
