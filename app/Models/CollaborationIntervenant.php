<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollaborationIntervenant extends Model
{
    protected $table = 'historiquecollaborateurintervenant'; // ou 'missions' si tu réutilises la table missions
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'mission_id',
        'intervenant_id',
        'ecole_id',
        'nom_ecole',
        'nom_intervenant',
        'prenom_intervenant',
        'titre_mission',
        'montant'
    ];
}