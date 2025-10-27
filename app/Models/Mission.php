<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;


    // Désactiver les timestamps automatiques
    public $timestamps = false;

    // Spécifier le nom de la table (au singulier)
    protected $table = 'mission';

    // Spécifier le nom de la clé primaire
    protected $primaryKey = 'id_mission';

    // Spécifier que la clé primaire n'est pas auto-incrémentée
    public $incrementing = false;

    // Spécifier le type de la clé primaire
    protected $keyType = 'string';

    protected $fillable = [
        'titre',
        'descriptions_mission',
        'intervenant_id',
        'ecole_id',
        'date_debut',
        'date_fin',
        'date_creation',
        'duree',
        'conditions'
    ];

    // Si vous voulez utiliser date_creation comme created_at
    const CREATED_AT = 'date_creation';
}