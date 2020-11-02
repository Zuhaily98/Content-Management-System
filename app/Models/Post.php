<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'content', 'image', 'published_at', 'category_id'
    ];


    /**
     * Delete post image from storage
     * 
     * @return void
     */
    public function deleteImage()
    {
        Storage::delete($this->image);
    }

    public function category() //category() is the name of model in small case
    {
        return $this->belongsTo(Category::class); //tells laravel that Post model belongs to Category model
    }

    public function tags() //tags with s because many to many
    {
        return $this->belongsToMany(Tag::class);
    }

}
