<?php

namespace App;

use App\Events\ThreadReceivedNewReply;
use App\RecordsActivity;
use App\Reply;
use App\Thread;
use App\ThreadSubscription;
use App\User;
use App\Utilities\Visits;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Thread extends Model
{

    use RecordsActivity, Searchable;

    public $asYouType = false;

    public function toSearchableArray()
    {
        $array = [
            'id' => $this->id,
            'title' => $this->title,
            'body'  => $this->body,
        ];

        return $array;
    }

    protected $guarded = [];

    protected $with    = ['creator', 'channel'];
    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each(function ($reply) {
                $reply->delete();
            });
        });

        static::created(function ($thread) {
            $thread->update(['slug' => $thread->title]);
        });
    }

    /**
     * generating thread own path
     *
     * @return string */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->slug}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
        if ($this->locked) {
            throw new \App\Exceptions\ThreadLockedException();
        }

        $reply = $this->replies()->create($reply);
        event(new ThreadReceivedNewReply($reply));

        return $reply;
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id(),
        ]);

        return $this;
    }

    /*
     * Function for :: unsubscribe ::
     *
     */
    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function hasUpdatesFor($user = null)
    {
        $user = $user ?: auth()->user();
        $key  = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

    public function visits()
    {
        return new Visits($this);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        $slug = str_slug($value);

        if (static::whereSlug($slug)->exists()) {
            $slug = "{$slug}-{$this->id}";
        }

        $this->attributes['slug'] = $slug;
    }

    public function markBestReply(Reply $reply)
    {
        $this->update(['best_reply_id' => $reply->id]);
    }
}
