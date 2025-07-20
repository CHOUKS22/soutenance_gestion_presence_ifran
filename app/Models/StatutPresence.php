<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatutPresence extends Model
{
    use HasFactory;

    protected $table = 'statuts_presences';

    protected $fillable = [
        'libelle',
        'description',
    ];

    // Relation : Un statut de présence peut être associé à plusieurs présences d'étudiants
    public function presences()
    {
        return $this->hasMany(Presence::class, 'statuts_presence_id');
    }
}
