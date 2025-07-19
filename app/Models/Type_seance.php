<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type_seance extends Model
{
    protected $table = 'types_seances';

    protected $fillable = [
        'nom',
        'description',
    ];

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
