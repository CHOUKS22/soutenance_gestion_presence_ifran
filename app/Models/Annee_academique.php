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
}
