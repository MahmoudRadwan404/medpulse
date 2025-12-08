<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    //
    protected $fillable = [
        'name_en',
        'name_ar',
        'speciality_en',
        'speciality_ar',
    ];

    /**
     * Get the articles for the author.
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_authors')
                    ->withTimestamps();
    }

    /**
     * Get the events for the author.
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_authors')
                    ->withTimestamps();
    }
    
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
