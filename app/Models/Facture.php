<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $table = 'factureassocieesauxmissions';
    protected $primaryKey = 'id_facture';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'mission_id',
        'intervenant_id',
        'ecole_id',
        'nom_ecole',
        'titre_mission',
        'montant',
        'date_creation',
        'date_paiement',
        'statut',
    ];
}
