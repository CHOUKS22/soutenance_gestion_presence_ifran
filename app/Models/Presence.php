<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'seance_id',
        'statuts_presence_id',
        'created_by',
    ];

    // Relation : Une présence appartient à un étudiant
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    // Relation : Une présence appartient à une séance
    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }

    // Relation : Une présence appartient à un statut de présence
    public function statutPresence()
    {
        return $this->belongsTo(StatutPresence::class, 'statuts_presence_id');
    }

    // Relation : Une présence est créée par un utilisateur
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
