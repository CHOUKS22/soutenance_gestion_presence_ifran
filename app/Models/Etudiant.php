<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $fillable = [
        'user_id',
        'date_naissance',
        'lieu_naissance',
        'telephone',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation many-to-many avec les parents
     */
    public function parents()
    {
        return $this->belongsToMany(Parent_model::class, 'etudiants_parents', 'etudiant_id', 'parent_id');
    }

    /**
     * Relation many-to-many avec les années-classes
     */
    public function anneesClasses()
    {
        return $this->belongsToMany(AnneeClasse::class, 'annee_classe_etudiant', 'etudiant_id', 'annee_classe_id')
                    ->withTimestamps();
    }

    /**
     * Relation : Un étudiant peut avoir plusieurs présences
     */
    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function getAgeAttribute()
    {
        if ($this->date_naissance) {
            return $this->date_naissance->age;
        }
        return null;
    }
}
