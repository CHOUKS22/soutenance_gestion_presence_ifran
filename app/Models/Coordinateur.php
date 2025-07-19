<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinateur extends Model
{
    protected $fillable = [
        'user_id',
        'role',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
