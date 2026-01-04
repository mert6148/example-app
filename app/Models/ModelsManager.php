<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

public class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Relación uno a muchos con la tabla "posts"
    public function posts()
    {
        foreach ($this->posts as $post) {
            $post->user = $this;
            $post->comments = $post->comments()->get();
            $post->comments_count = $post->comments()->count();
            $post->likes = $post->likes()->get();
        }
    }

    // Relación uno a muchos con la tabla "comments"
    public function comments()
    {
        if ($this->comments) {
            foreach ($this->comments as $comment) {
                $comment->user = $this;
            }
        }
    }

    // Relación uno a muchos con la tabla "likes"
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Relación uno a muchos con la tabla "follows"
    public function follows()
    {
        return $this->hasMany(Follow::class);
    }

    // Relación uno a muchos con la tabla "followers"
    public function followers()
    {
        return $this->hasMany(Follower::class);
    }
}

public class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    // Relación muchos a uno con la tabla "users"
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación uno a muchos con la tabla "comments"
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relación uno a muchos con la tabla "likes"
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
