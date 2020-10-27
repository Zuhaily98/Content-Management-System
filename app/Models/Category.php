<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    //attributes for mass assignment
    protected $fillable = ['name'];

    public function posts() //notice posts is with 's' bcs of hasMany relationship
    {
        return $this->hasMany(Post::class);
    }
}
