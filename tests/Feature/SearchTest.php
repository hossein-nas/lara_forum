<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_search_threads()
    {
        config(['scout.driver' => 'tntsearch']);

        $search = "Foobar";

        create(Thread::class, [], 2);
        create(Thread::class, ['body' => "A thread with a {$search} term"], 2);

        do {
            sleep(.1);
            
            $results = $this->getJson("/threads/search?q={$search}")->json()['data'];
        } while (empty($results));

        $this->assertCount(2, $results);

        // deleting threads that created in firstplace.
        Thread::latest()->take(4)->unsearchable();

        $results = $this->getJson("/threads/search?q={$search}")->json()['data'];
        $this->assertCount(0, $results);
    }
}
