<?php

namespace Tests\Feature;

use App\User;
use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotificationsTest extends TestCase {use DatabaseMigrations; public function setUp() {parent::setUp(); $this->signIn(); }
    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_thread_received_a_new_reply_that_is_not_by_current_user()
    {
        $thread = create(Thread::class);
        $thread->subscribe();
         
        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply(factory(Reply::class)
            ->raw(['user_id' => auth()->id()]));
        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply(factory(Reply::class)
            ->raw(['user_id' => create(User::class)->id]));
        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_fetch_their_unread_notifications()
    {
        $user = $this->user;

        create(DatabaseNotification::class);

        $response = $this->getJson("/profiles/{$user->name}/notifications")->json();
        $this->assertCount(1, $response);
    }
    

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {
        $user = $this->user;

        create(DatabaseNotification::class);

        $this->assertCount(1, $user->unreadNotifications);

        $notificationId = $user->unreadNotifications->first()->id;
        $this->delete("/profiles/". $user->name ."/notifications/{$notificationId}");

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
      
}
