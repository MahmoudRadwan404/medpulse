<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAnalysis extends Model
{
    //
    protected $fillable = [
        'event_id',
        'description_en',
        'description_ar',
        'content_rate',
        'content_rate_description_en',
        'content_rate_description_ar',
        'organisation_rate',
        'organisation_rate_description_en',
        'organisation_rate_description_ar',
        'speaker_rate',
        'speaker_rate_description_en',
        'speaker_rate_description_ar',
        'sponsering_rate',
        'sponsering_rate_description_en',
        'sponsering_rate_description_ar',
        'scientific_impact_rate',
        'scientific_impact_rate_description_en',
        'scientific_impact_rate_description_ar',
        'total',
    ];

    protected $casts = [
        'content_rate' => 'float',
        'organisation_rate' => 'float',
        'speaker_rate' => 'float',
        'sponsering_rate' => 'float',
        'scientific_impact_rate' => 'float',
        'total' => 'float',
    ];

    /**
     * Get the event that owns the analysis.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

}
