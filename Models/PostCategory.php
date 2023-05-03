<?php

namespace Modules\Posts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function post()
    {
        return $this->hasMany(Post::class, 'post_category_id');
    }
}
