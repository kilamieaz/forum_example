<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->withoutExceptionHandling()->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/threads/some-channel/1/replies', []);
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply', ['thread_id' => $thread->id]);
        $this->post($thread->path() . '/replies', $reply->toArray());
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);
        $this->json('POST', $thread->path() . '/replies', $reply->toArray())
        ->assertStatus(422);
    }

    /** @test */
    public function unauthorized_users_cannot_delete_replies()
    {
        $this->withExceptionHandling();
        $reply = create('App\Reply');
        $this->delete("/replies/$reply->id")
        ->assertRedirect('login');

        $this->signIn()
        ->delete("/replies/$reply->id")
        ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        $this->delete("/replies/$reply->id")->assertStatus(302);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }

    /** @test */
    public function unauthorized_users_cannot_update_replies()
    {
        $this->withExceptionHandling();
        $reply = create('App\Reply');
        $this->patch("/replies/$reply->id")
        ->assertRedirect('login');

        $this->signIn()
        ->patch("/replies/$reply->id")
        ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_update_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        $updatedReply = 'You been changed, fool.';
        $this->patch("/replies/$reply->id", ['body' => $updatedReply]);
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }

    /** @test */
    public function replies_that_contains_spam_not_be_created()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply', [
            'body' => 'Yahoo Customer Support'
        ]);
        $this->json('POST', $thread->path() . '/replies', $reply->toArray())
        ->assertStatus(422);
    }

    /** @test */
    public function users_may_only_reply_a_maximum_of_once_per_minute()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply', [
            'body' => 'My simple reply.'
        ]);
        $this->post($thread->path() . '/replies', $reply->toArray())
        ->assertStatus(201);
        // ->assertStatus(200); //still error
        $this->post($thread->path() . '/replies', $reply->toArray())
        ->assertStatus(429);
    }
}
