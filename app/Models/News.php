<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'type',
        'image',
        'publish_date',
    ];

    /**
     * Relationship: News has many comments.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    /**
     * Relationship: News has many likes/dislikes.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Count of likes.
     */
    public function likesCount(): int
    {
        return $this->likes()->where('is_like', true)->count();
    }

    /**
     * Count of dislikes.
     */
    public function dislikesCount(): int
    {
        return $this->likes()->where('is_like', false)->count();
    }
}
