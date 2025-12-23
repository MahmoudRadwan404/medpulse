<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticData extends Model
{
    
    protected $fillable = ['title', 'attributes'];

    protected $casts = [
        'attributes' => 'array',
    ];
}
