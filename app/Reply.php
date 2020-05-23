<?php

namespace App;

use App\Thread;
use App\Favorite;
use App\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
	use Favoritable, RecordsActivity;

	protected $guarded = [];

	protected $with = ['owner', 'favorites'];

    protected $appends = ['favorites_count', 'favorited_by_me'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
    	return $this->belongsTo(Thread::class);	
    }

    public function path()
    {
        return "{$this->thread->path()}#reply-no-{$this->id}";
    }


}
