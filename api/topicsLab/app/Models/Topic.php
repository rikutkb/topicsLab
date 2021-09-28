<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function topicLikes()
    {
        return $this->hasMany(TopicLike::class);
    }
    public function commentLikes()
    {
        return $this->hasManyThrough(CommentLike::class, Comment::class);
    }
    public static function scopeSimpleAllList($query)
    {
        return $query->select(['id', 'title', 'created_at', 'img_path']);
    }
}
