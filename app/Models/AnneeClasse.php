<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnneeClasse extends Model
{
    use HasFactory;

    protected $table = 'annee_classes';

    protected $fillable = [
        'annee_academique_id',
        'classe_id',
        'coordinateur_id',
    ];

    // Relations
    public function anneeAcademique()
    {
        return $this->belongsTo(Annee_academique::class, 'annee_academique_id');
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe_id');
    }

    public function coordinateur()
    {
        return $this->belongsTo(Coordinateur::class, 'coordinateur_id');
    }

    // Relation many-to-many avec les étudiants via la table pivot
    public function etudiants()
    {
        return $this->belongsToMany(Etudiant::class, 'annee_classe_etudiant', 'annee_classe_id', 'etudiant_id')
                    ->withTimestamps();
    }
}
