<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    //
    protected $table = 'article_categories';

    protected $fillable = [
        'name_en',
        'name_ar',
    ];

    /**
     * Get the articles for the category.
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }
}
