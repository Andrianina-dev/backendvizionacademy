<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Ecole extends Authenticatable
{
    use HasFactory;

    protected $table = 'ecole';
    protected $primaryKey = 'id_ecole';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_ecole',
        'nom_ecole',
        'email',
        'mot_de_passe',
        'telephone',
        'adresse',
        'date_derniere_connexion',
        'date_creation'
    ];

    protected $hidden = [
        'mot_de_passe'
    ];

    protected $casts = [
        'date_derniere_connexion' => 'datetime',
        'date_creation' => 'datetime'
    ];

    // Si vous utilisez l'authentification Laravel
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }
}
