<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LockThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function non_admistrator_may_not_lock_threads()
    {
        $this->signIn()
            ->withExceptionHandling();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->post(route('lock-threads.store', $thread))
            ->assertStatus(403);
    }

    /** @test */
    public function adminstrators_can_lock_threads()
    {
        $admin = factory('App\User')->states('adminstrator')->create();
        $this->signIn($admin);

        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->post(route('lock-threads.store', $thread))
            ->assertStatus(200);

        $this->assertTrue(!!$thread->fresh()->locked);
    }

    /** @test */
    public function once_locked_a_thread_may_not_receive_new_replies()
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
