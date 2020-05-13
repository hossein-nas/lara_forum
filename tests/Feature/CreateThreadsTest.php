<?php

namespace Tests\Feature;

use App\Thread; use App\User; use Illuminate\Foundation\Testing\DatabaseMigrations; use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
	use DatabaseMigrations;
 	/** @test */
	public function guests_may_not_create_threads()
	{
		$this->withExceptionHandling();

		$this->post('/threads', [])
			->assertRedirect('/login');

		$this->get('/threads/create')
			->assertRedirect('/login');
	}

	/** @test */
	public function an_authenticated_user_can_create_form_threads()
	{
		$this->signIn();

		$thread = create(Thread::class);

		$this->post('threads', $thread->toArray() );

		$this->get($thread->path())
			->assertSee($thread->title)
			->assertSee($thread->body);
	}
	
}
