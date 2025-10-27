<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intervenant extends Model
{
    protected $table = 'intervenant';
    protected $primaryKey = 'id_intervenant';
    public $incrementing = false;

    protected $fillable = [
        'nom_intervenant',
        'prenom_intervenant',
        'email_login',
        'mot_de_passe',
        'photo_intervenant',
        'bio_intervenant',
        'diplome',
        'cv',
        'video',
        'langues',
        'domaines',
        'ville',
        'disponibilite',
        'date_derniere_connexion',
    ];

    protected $casts = [
        'langues' => 'array',
        'domaines' => 'array',
    ];

        // Relation avec les favoris
    public function favoris()
    {
        return $this->hasMany(FavorisIntervenant::class, 'intervenant_id', 'id_intervenant');
    }

    // Relation avec les missions
    public function missions()
    {
        return $this->hasMany(Mission::class, 'intervenant_id', 'id_intervenant');
    }
}