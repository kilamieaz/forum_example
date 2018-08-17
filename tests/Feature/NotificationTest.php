<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotificationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {
        $this->signIn();
        $thread = create('App\Thread')->subscribe();
        // no reply = no notification
        $this->assertCount(0, auth()->user()->notifications);
        // then, each time a new reply from the user.
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'some reply here'
        ]);
        // after add reply, user dont get notification.
        $this->assertCount(0, auth()->user()->fresh()->notifications);

        // then, each time a new reply is left.
        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'some reply here'
        ]);
        // after add reply, user get notification.
        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {
        $this->signIn();
        $thread = create('App\Thread')->subscribe();
        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'some reply here'
        ]);
        $user = auth()->user();
        $response = $this->getJson("/profiles/$user->name/notifications")->json();
        $this->assertCount(1, $response);
    }

    /** @test */
    public function a_user_can_clear_a_notification()
    {
        $this->signIn();
        $thread = create('App\Thread')->subscribe();
        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'some reply here'
        ]);
        $user = auth()->user();
        $notificationId = $user->unreadNotifications->first()->id;
        $this->assertCount(1, $user->unreadNotifications);
        $this->delete("/profiles/$user->name/notifications/$notificationId");
        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
