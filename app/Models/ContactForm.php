<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    //
    protected $table = 'contact_forms';

    protected $fillable = [
        'full_name',
        'organisation',
        'email',
        'number',
        'asking_type',
        'details',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];
}
