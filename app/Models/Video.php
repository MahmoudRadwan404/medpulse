<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
    protected $fillable = [
        'base_url',
        'name',
        'type',
        'article_id',
        'expert_id',
        'event_id',
        'front_sittings_id',
    ];

    /**
     * Get the article that owns the video (direct relationship).
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Get the expert that owns the video (direct relationship).
     */
    public function expert()
    {
        return $this->belongsTo(Expert::class);
    }

    /**
     * Get the event that owns the video (direct relationship).
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function frontSitting()
    {
        return $this->belongsTo(FrontSittings::class, 'front_sittings_id');
    }

}
