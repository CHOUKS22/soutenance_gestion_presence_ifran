<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    protected $fillable = [
        'annee_academique_id',
        'libelle',
        'date_debut',
        'date_fin',
    ];

    public function anneeAcademique()
    {
        return $this->belongsTo(Annee_Academique::class);
    }
}
