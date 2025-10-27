<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionAvecEtat extends Model
{
    protected $table = 'mission_avec_etat';

    // Si votre view a une clé primaire
    protected $primaryKey = 'id_mission';

    // Si id_mission est un VARCHAR
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Les colonnes disponibles dans la view
     * - id_mission
     * - titre
     * - descriptions_mission
     * - intervenant_id
     * - ecole_id
     * - nom_ecole
     * - date_debut
     * - date_fin
     * - date_creation
     * - etat_mission (calculé automatiquement)
     */
    protected $fillable = [
        'id_mission',
        'titre',
        'descriptions_mission',
        'intervenant_id',
        'ecole_id',
        'nom_ecole',
        'date_debut',
        'date_fin',
        'date_creation',
        'etat_mission'
    ];

    /**
     * Casting des dates pour un bon traitement
     */
    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'date_creation' => 'datetime'
    ];

    /**
     * Puisque c'est une view, on désactive les opérations d'écriture
     */
    public $timestamps = false;

    // Si vous voulez pouvoir utiliser les relations
    public function ecole()
    {
        return $this->belongsTo(Ecole::class, 'ecole_id', 'id_ecole');
    }

    public function intervenant()
    {
        return $this->belongsTo(Intervenant::class, 'intervenant_id');
    }
}
