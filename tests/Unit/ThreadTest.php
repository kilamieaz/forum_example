<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Thread;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ThreadWasUpdated;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;
    protected $thread;

    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');
        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
    }

    /** @test */
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    /** @test */
    public function a_thread_has_replies()
    {
        //this using has many
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $this->assertInstanceOf('App\Channel', $this->thread->channel);
    }

    /** @test */
    public function a_thread_can_be_subscribed_to()
    {
        // given we have a thread
        $thread = create('App\Thread');
        // and an authenticated user
        // $this->signIn();
        // when the user subscribes to the thread
        $thread->subscribe($userId = 1);
        // then we should be able to fetch all threads that the user has subscribed to.
        $this->assertEquals(1, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    public function a_thread_can_be_unsubscribed_from()
    {
        // given we have a thread
        $thread = create('App\Thread');
        // and a user who is subscribed to the Thread
        $thread->subscribe($userId = 1);
        $thread->unsubscribe($userId);
        $this->assertCount(0, $thread->subscriptions);
    }

    /** @test */
    public function it_knows_if_the_authenticated_user_is_subscribed_to_it()
    {
        // given we hav a Thread
        $thread = create('App\Thread');
        // and a user who is subscribed to the thread
        $this->signIn();
        $this->assertFalse($thread->isSubscribedTo);
        $thread->subscribe();
        $this->assertTrue($thread->isSubscribedTo);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        Notification::fake();

        $this->signIn()
        ->thread->subscribe()
        ->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'some reply'
        ]);
        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    /** @test */
    public function a_thread_can_check_if_the_authenticated_user_has_read_all_replies()
    {
        $this->signIn();
        $thread = create('App\Thread');
        tap(auth()->user(), function ($user) use ($thread) {
            $this->assertTrue($thread->hasUpdatesFor($user));
            // $key = sprintf('users.%s.visits.%s', $user, $thread->id);
            // simulate that the user visited the thread
            $user->read($thread);
            $this->assertFalse($thread->hasUpdatesFor($user));
        });
    }
}
