<?php

namespace Tests\Feature;

use App\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function guests_cannot_favorite_anything()
	{
		$this->withExceptionHandling()
			->post('replies/1/favorites')
			->assertRedirect('/login');
	}
	

	/** @test */
	public function an_authenticated_user_can_favorite_any_reply()
	{
		$this->signIn();

		$reply = create(Reply::class);

		$this->post('/replies/' . $reply->id . "/favorites");
 $this->assertCount(1, $reply->favorites); }

	/** @test */
	public function an_authenticated_user_can_unfavorite_a_reply()
	{
		$this->signIn();

		$reply = create(Reply::class);
		$reply2 = create(Reply::class);

		$this->post('/replies/' . $reply->id . "/favorites");
		$this->delete('/replies/' . $reply->id . "/favorites");
		$this->delete('/replies/' . $reply2->id . "/favorites");

		$this->assertCount(0, $reply->favorites);
	}

	/** @test */
	public function an_authenticated_user_may_only_favorite_a_reply_once()
	{
			
		$this->signIn();

		$reply = create(Reply::class);

		$this->post('/replies/' . $reply->id . "/favorites");
		$this->post('/replies/' . $reply->id . "/favorites");

		$this->assertCount(1, $reply->favorites);
	}
	
	
}
