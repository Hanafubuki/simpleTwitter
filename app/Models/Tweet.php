<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    /**
    * Create one to many relationship with User Class.
    * author_id belongs to Tweet Class and id to User Clas.
    **/
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }
}
