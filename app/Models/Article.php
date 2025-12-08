<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $fillable = [
        'category_id',
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
    ];

    /**
     * Get the category that owns the article.
     */
    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }
    public function authors()
    {
        return $this->belongsToMany(Author::class, 'article_authors')
                    ->withTimestamps();
    }
 
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Get the videos for the article.
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
