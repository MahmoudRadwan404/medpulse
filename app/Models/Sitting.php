<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sitting extends Model
{
    //
    protected $fillable = [
        'posts_number',
        'events_number',
    ];

    protected $casts = [
        'posts_number' => 'integer',
        'events_number' => 'integer',
    ];

}
