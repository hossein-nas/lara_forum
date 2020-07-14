<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TrendingThreadsTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp()
    {
        parent::setUp();

        Redis::del('trending_threads');    
    }

    /** @test */
    public function it_increments_a_thread_score_each_time_it_is_read()
    {
        $this->assertEmpty(Redis::zrevrange('trending_threads', 0 , -1));

        $thread = create(Thread::class);

        $this->call('GET', $thread->path());

        $trending = Redis::zrevrange('trending_threads', 0 , -1);
        $this->assertCount(1, $trending);
        $this->assertEquals($thread->title, json_decode($trending[0])->title);
    }
}
