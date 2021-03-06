<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\Activity;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function it_records_activity_when_a_thread_is_created()
	{
		$this->signIn();
		
		$thread = create(Thread::class);

		$this->assertDatabaseHas('activities', [
			'type' 			=> 'created_thread',
			'user_id' 		=> auth()->id(),
			'subject_id'	=> $thread->id,
			'subject_type'	=> 'App\Thread'	
		]);

		$activity = Activity::first();

		$this->assertEquals($activity->subject->id, $thread->id);
	}

	/** @test */
	public function it_records_activity_when_a_reply_is_created()
	{
		$this->signIn();

		$reply = create(Reply::class);

		$this->assertDatabaseHas('activities', [
			'user_id' 			=> auth()->id(),
			'type'				=> 'created_reply',
			'subject_id' 		=> $reply->id,
			'subject_type'		=> 'App\Reply',
		]);

		$this->assertCount(2, Activity::all() );
	}

	/** @test */
	public function it_fetches_a_feed_for_any_user()
	{
		$this->signIn();

		create(Thread::class, ['user_id' => auth()->id()], 2);
		auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

		$feed = Activity::feed(auth()->user());

		$this->assertTrue($feed->keys()->contains(
			Carbon::now()->format('Y-m-d')
		));
		$this->assertTrue($feed->keys()->contains(
			Carbon::now()->subWeek()->format('Y-m-d')
		));
	}

}
