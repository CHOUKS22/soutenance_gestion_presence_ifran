<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parent_model extends Model
{
    use HasFactory;

    protected $table = 'parents';

    protected $fillable = [
        'user_id',
        'telephone',
        'type_relation',
    ];

    /**
     * Relation avec le modèle User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation many-to-many avec les étudiants
     */
    public function etudiants()
    {
        return $this->belongsToMany(Etudiant::class, 'etudiants_parents', 'parent_id', 'etudiant_id');
    }
}
