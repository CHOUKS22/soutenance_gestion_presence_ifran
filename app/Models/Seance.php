<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    protected $fillable = [
        'classe_id',
        'matieres_id',
        'professeur_id',
        'statut_seance_id',
        'semestre_id',
        'type_seance_id',
        'date_debut',
        'date_fin',
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'matieres_id');
    }

    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }

    public function statutSeance()
    {
        return $this->belongsTo(Statut_seance::class, 'statut_seance_id');
    }

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    public function typeSeance()
    {
        return $this->belongsTo(Type_seance::class, 'type_seance_id');
    }
}
