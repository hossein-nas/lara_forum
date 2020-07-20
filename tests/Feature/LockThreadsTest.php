<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LockThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_admistrator_can_lock_any_thread()
    {

        $this->withExceptionHandling()
            ->signIn();

        $thread = create(Thread::class);

        $thread->lock();

        $this->post($thread->path() . '/replies', [
            'body' => 'Foobar', 
            'user_id' => auth()->id(),
        ])
            ->assertStatus(422);
    }
}
