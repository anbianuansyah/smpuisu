<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id'
    ];
}