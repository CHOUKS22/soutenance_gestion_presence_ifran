<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    protected $fillable = [
        'user_id',
        'filliere_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function filliere()
    {
        return $this->belongsTo(Filliere::class);
    }

    public function seances()
    {
        return $this->hasMany(Seance::class, 'professeur_id');
    }
}
