<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrontSittings extends Model
{
    //
    protected $table = 'front_sittings';

    protected $fillable = [
        'mode'
    ];

    /**
     * Get the images for the front sitting.
     */
    public function images()
    {
        return $this->hasMany(Image::class, 'front_sittings_id');
    }

    /**
     * Get the videos for the front sitting.
     */
    public function videos()
    {
        return $this->hasMany(Video::class, 'front_sittings_id');
    }

}
