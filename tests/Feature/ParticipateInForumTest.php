<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function an_authenticated_user_may_participate_in_forum_threads()
	{
		$this->be($user = factory(User::class)->create() );
		$thread = create(Thread::class);
		$reply = make(Reply::class);

		$this->post($thread->path() . '/replies', $reply->toArray() );

		$this->get($thread->path())
			->assertSee($reply->body);
	}

	/** @test */
	public function unauthenticated_user_may_not_add_replies()
	{
		$this->withExceptionHandling()
			->post('/threads/some-channel/1/replies', [])
			->assertRedirect("/login");
	}
	
}
