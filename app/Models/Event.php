<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = [
        'title_en',
        'title_ar',
        'location',
        'date_of_happening',
        'stars',
        'rate',
        'organizer_en',
        'organizer_ar',
        'description_en',
        'description_ar',
        'subjects_description_en',
        'subjects_description_ar',
        'subjects',
        'authors_description_en',
        'authors_description_ar',
        'comments_for_medpulse_en',
        'comments_for_medpulse_ar',
    ];

    protected $casts = [
        'date_of_happening' => 'date',
        'stars' => 'integer',
        'rate' => 'float',
        'subjects' => 'array',
    ];

    /**
     * Get the analysis for the event.
     */
    public function analysis()
    {
        return $this->hasOne(EventAnalysis::class);
    }

    /**
     * Get the authors for the event.
     */
    public function authors()
    {
        return $this->belongsToMany(Author::class, 'event_authors')
                    ->withTimestamps();
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Get the videos for the event.
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
