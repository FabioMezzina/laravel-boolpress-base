<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'body',
        'author',
        'slug',
        'path_img'
    ];

    // relation with tags
    public function tags() {
        return $this->belongsToMany('App\Tag');
    }
}
