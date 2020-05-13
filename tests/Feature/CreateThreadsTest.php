<?php

namespace Tests\Feature;

use App\Channel;
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

		$thread = make(Thread::class);

		$response = $this->post('threads', $thread->toArray() );

		$this->get($response->headers->get('Location'))
			->assertSee($thread->title)
			->assertSee($thread->body);
	}

	/** @test */
	public function a_thread_requires_a_title()
	{
		$this->publishThread(['title' => null])
			->assertSessionHasErrors('title');
	}

	/** @test */
	public function a_thread_requires_a_body()
	{
		$this->publishThread(['body' => null])
			->assertSessionHasErrors('body');
	}

	/** @test */
	public function a_thread_requires_a_channel_id()
	{
		$this->publishThread(['channel_id' => null])
			->assertSessionHasErrors('channel_id');
	}

	/** @test */
	public function a_thread_requires_a_valid_channel_id()
	{
		factory(Channel::class, 2)->create();

		$this->assertCount(2, Channel::all());

		$this->publishThread(['channel_id' => 3])
			->assertSessionHasErrors('channel_id');
	}

	public function publishThread($overrides = [])
	{
		$this->withExceptionHandling()
			->signIn();

		$thread = make(Thread::class, $overrides);

		return $this->post('/threads', $thread->toArray());
	}
	
	
}