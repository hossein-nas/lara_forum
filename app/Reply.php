<?php

namespace App;

use App\RecordsActivity;
use App\Thread;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected $appends = ['favorites_count', 'favorited_by_me', 'isBest'];

    public static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });
        static::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function mentionedUsers()
    {
        preg_match_all('/\@([\w\-]+)/i', $this->body, $matches);

        return $matches[1];
    }

    public function path()
    {
        return "{$this->thread->path()}#reply-no-{$this->id}";
    }

    public function setBodyAttribute($body)
    {
        // Hey @JaneDoe
        // Hey <a href="/profiles/JaneDoe">JaneDoe</a>
        $this->attributes['body'] = preg_replace(
            '/@([\w\-]+)/',
            "<a href=\"/profiles/$1\">$0</a>",
            $body
        );
    }

    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }
}
