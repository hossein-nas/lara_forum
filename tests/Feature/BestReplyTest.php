<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BestReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_thread_creator_may_mark_any_reply_as_the_best_reply()
    {
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $replies = create(Reply::class, ['thread_id' => $thread->id], 2);

        $this->assertFalse($replies[1]->fresh()->isBest());
        $this->postJson(route('best-replies.store', ['reply' => $replies[1]->id]));
        $this->assertTrue($replies[1]->fresh()->isBest());
    }

    /** @test */
    public function only_the_thread_creator_may_mark_a_reply_as_best()
    {
        $this->withExceptionHandling();
        $this->signIn();

        $thread = create(Thread::class);
        $replies = create(Reply::class, ['thread_id' => $thread->id], 2);

        $this->signIn($user2 = create(User::class));

        $this->postJson(route('best-replies.store', ['reply' => $replies[1]->id]))
            ->assertStatus(403);
        $this->assertFalse($replies[1]->fresh()->isBest());
    }
}
