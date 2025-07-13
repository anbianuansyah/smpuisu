<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug'
    ];

    /**
     * posts
     *
     * @return void
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}