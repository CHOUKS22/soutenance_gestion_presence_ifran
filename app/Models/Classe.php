<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $fillable = [
        'nom',
    ];

    /**
     * Relation avec les années-classes
     */
    public function anneesClasses()
    {
        return $this->hasMany(AnneeClasse::class, 'classe_id');
    }

    /**
     * Relation avec les séances
     */
    public function seances()
    {
        return $this->hasMany(Seance::class, 'classe_id');
    }
}
