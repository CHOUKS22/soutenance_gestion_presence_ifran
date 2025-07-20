<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annee_academique extends Model
{
    protected $table = 'annees_academiques';

    protected $fillable =[
        'libelle',
        'date_debut',
        'date_fin',
    ];

    /**
     * Relation avec les années-classes
     */
    public function anneesClasses()
    {
        return $this->hasMany(AnneeClasse::class, 'annee_academique_id');
    }

    /**
     * Relation avec les semestres
     */
    public function semestres()
    {
        return $this->hasMany(Semestre::class, 'annee_academique_id');
    }
}
