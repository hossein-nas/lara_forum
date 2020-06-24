<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ThreadWasUpdated extends Notification
{
    protected $thread;
    protected $reply;

    use Queueable;

    /**
     * [__construct description]
     * @param Thread $thread 
     * @param Reply $reply  
     */
    public function __construct($thread, $reply)
    {
        $this->thread = $thread;
        $this->reply = $reply;
    }

    /**
     * [via description]
     * @param  [type] $notifiable 
     * @return Array             
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Temporary placeholder.'
        ];
    }
}
