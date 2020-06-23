<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_subscribe_to_threads()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $response = $this->post($thread->path() . '/subscriptions');

        $thread->addReply(factory(Reply::class)->raw(['user_id' => auth()->id()]));

        // $this->assertCount(1, auth()->user()->notifications);
    }
    
}
