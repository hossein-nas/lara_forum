<?php

namespace Tests\Feature;

use App\User;
use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $john = create(User::class, ['name' => "JohnDoe"]);
        $jane = create(User::class, ['name' => "JaneDoe"]);

        $this->signIn($john);

        $thread = create(Thread::class);
        $reply = make(Reply::class, [
            'body' => '@JaneDoe Look at this. Also @FrankDoe',
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }
}
