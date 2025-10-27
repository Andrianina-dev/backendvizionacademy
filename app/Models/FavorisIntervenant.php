<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavorisIntervenant extends Model
{
    use HasFactory;

    protected $table = 'favoris_intervenant';
    protected $primaryKey = 'id_favoris';

    protected $fillable = [
        'ecole_id',
        'intervenant_id',
        'date_ajout'
    ];

    public $timestamps = false;

    protected $casts = [
        'date_ajout' => 'datetime',
    ];

    // Relation avec l'intervenant
    public function intervenant()
    {
        return $this->belongsTo(Intervenant::class, 'intervenant_id', 'id_intervenant');
    }

    // Relation avec l'école
    public function ecole()
    {
        return $this->belongsTo(Ecole::class, 'ecole_id', 'id_ecole');
    }
}
