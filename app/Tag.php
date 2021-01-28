<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    // relation with articles
    public function articles() {
        return $this->belongsToMany('App\Article');
    }
}
