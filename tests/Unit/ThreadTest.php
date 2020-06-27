<?php

namespace Tests\Unit;

use App\User;
use App\Thread;
use Tests\TestCase;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();    
    }
    

    /** @test */
    function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /** @test */
    public function a_thread_has_creator()
    {
    	$this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {

        $this->thread->addReply([
            'body'      => 'foobar',
            'user_id'   => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        Notification::fake();

        $this->signIn()
            ->thread
            ->subscribe()
            ->addReply([
                'body'      => 'foobar',
                'user_id'   => 999
            ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }
    

    /** @test */
    public function a_thread_belongs_to_channel()
    {
        $thread = create(Thread::class);

        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    /** @test */
    public function a_thread_can_make_string_path()
    {
        $thread = create(Thread::class);

        $this->assertEquals(
            "/threads/{$thread->channel->slug}/{$thread->id}", 
            $thread->path()
        );
        
    }

    /** @test */
    public function a_thread_can_be_subscribed_to()
    {
        $thread = create(Thread::class);

        $thread->subscribe($userId = 1);

        $this->assertEquals(
            1,
            $thread->subscriptions()->where(['user_id' => $userId])->count()
        );
    }

    /** @test */
    public function a_thread_can_be_unsubscribed_from()
    {
        $thread = create(Thread::class);

        $thread->subscribe($userId = 1);
        $thread->unsubscribe($userId);

        $this->assertCount(0, $thread->subscriptions);
    }
    
}
