<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        // given a have a user, JohnDoe, who is signed in.
        $john = create('App\User', ['name' => 'JohnDoe']);
        $this->signIn($john);
        // and another use, JaneDoe.
        $jane = create('App\User', ['name' => 'JaneDoe']);
        // if we have a thread
        $thread = create('App\Thread');
        // and JohnDoe replies and mentions @JaneDoe.
        $reply = make('App\Reply', ['body' => '@JaneDoe look at this.']);
        $this->json('POST', $thread->path() . '/replies', $reply->toArray());
        // then, JaneDoe should be notified.
        $this->assertCount(1, $jane->notifications);
    }
}
