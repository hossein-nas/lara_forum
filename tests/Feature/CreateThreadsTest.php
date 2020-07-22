<?php

namespace Tests\Feature;

use App\Activity;
use App\Channel;
use App\Reply;
use App\Rules\Recaptcha;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();

        app()->singleton(Recaptcha::class, function () {
            return \Mockery::mock(Recaptcha::class, function ($m) {
                $m->shouldReceive('passes')->andReturn(true);
            });
        });
    }

    use DatabaseMigrations;
    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->post(route('threads'), [])
            ->assertRedirect(route('login'));

        $this->get('/threads/create')
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function new_user_must_first_confirm_their_email_address_before_creating_threads()
    {
        $user = factory(\App\User::class)->states('unconfirmed')->create();

        $this->signIn($user);

        $thread = make(Thread::class);

        $this->post(route('threads'), $thread->toArray())
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash');
    }

    /** @test */
    public function a_user_can_create_form_threads()
    {
        $this->signIn();

        $thread = make(Thread::class);

        $response = $this->post(
            route('threads'),
            $thread->toArray() + ['g-recaptcha-response' => 'token']
        );

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
    public function a_thread_requires_recaptcha_verification()
    {
        unset(app()[Recaptcha::class]);

        $this->publishThread(['g-recaptcha-response' => 'test'])
            ->assertSessionHasErrors('g-recaptcha-response');
    }

    /** @test */
    public function a_thread_requires_a_channel_id()
    {
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function a_thread_requires_a_unique_slug()
    {
        $this->signIn();
        $thread = create(Thread::class, ['title' => 'Foo Title']);
        $this->assertEquals('foo-title', $thread->fresh()->slug);

        $thread = $this->postJson(
            route('threads'),
            $thread->toArray() + ['g-recaptcha-response' => 'token']
        )->json();

        $this->assertEquals("foo-title-{$thread['id']}", $thread['slug']);
    }

    /** @test */
    public function a_thread_with_a_title_that_ends_in_a_number_should_generate_proper_slug()
    {
        $this->signIn();

        $thread = create(Thread::class, ['title' => 'Some Title 24']);
        $this->assertEquals('some-title-24', $thread->fresh()->slug);

        $thread = $this->postJson(
            route('threads'),
            $thread->toArray() + ['g-recaptcha-response' => 'token']
        )->json();

        $this->assertEquals("some-title-24-{$thread['id']}", $thread['slug']);
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

        return $this->post(route('threads'), $thread->toArray());
    }

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);
        $reply->favorite();

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, Activity::count());
    }

    /** @test */
    public function guests_cannot_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create(Thread::class);

        $this->delete($thread->path())->assertRedirect(route('login'));

        $this->signIn();

        $this->delete($thread->path())->assertStatus(403);
    }

    // /** @test */
    // public function threads_may_only_be_deleted_by_those_who_have_permission()
    // {
    //     // TODO:
    // }
}
