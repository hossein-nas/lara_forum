<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifySubscribers
{
    public function handle(ThreadReceivedNewReply $event)
    {
        $thread = $event->reply->thread;

        $thread->subscriptions
            ->where('user_id', '!=', $event->reply->user_id)
            ->each(function($sub) use ($event, $thread){
                $sub->user->notify(new ThreadWasUpdated($thread, $event->reply));
            });
    }
}
