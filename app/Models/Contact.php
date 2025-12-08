<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
  protected $guarded='id';
    protected $fillable = [
        'name_en',
        'name_ar',
        'link',
        'expert_id',
    ];

    /**
     * Get the expert that owns the contact.
     */
    public function expert()
    {
        return $this->belongsTo(Expert::class);
    }
}
