<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_subscribe_to_threads()
    {
        $this->signIn();
        // given we have a thread
        $thread = create('App\Thread');
        // and the user subscribes to the thread
        $this->post($thread->path() . '/subscriptions');
        // then, each time a new reply is left.
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'some reply here'
        ]);
        $this->assertCount(1, $thread->subscriptions);

        // a notification should be prepared for the user.
        // $this->assertCount(1, auth()->user()->notifications);
    }

    /** @test */
    public function a_user_can_unsubscribe_from_threads()
    {
        $this->signIn();
        // given we have a thread
        $thread = create('App\Thread');
        // and the user subscribes to the thread
        $thread->subscribe();
        $this->delete($thread->path() . '/subscriptions');
        // then, each time a new reply is left.
        $this->assertCount(0, $thread->subscriptions);
    }
}
