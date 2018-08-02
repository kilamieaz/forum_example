<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_may_not_create_threads()
    {
        // $this->withoutExceptionHandling()->expectException('Illuminate\Auth\AuthenticationException');
        $this->get('/threads/create')
        ->assertRedirect('/login');
        $this->post('/threads')
        ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        //given we have a signed in user
        $this->signIn();
        //when we hit the endpoint to create a new thread
        $thread = make('App\Thread');
        $response = $this->post('/threads', $thread->toArray());
        //then, when we visit the thread page
        $this->get($response->headers->get('Location'))
        //we should see the new thread
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
    public function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();
        $this->publishThread(['channel_id' => null])
        ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 99])
        ->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = [])
    {
        $this->signIn();
        $thread = make('App\Thread', $overrides);
        return $this->post('/threads', $thread->toArray());
    }
}
