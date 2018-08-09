<?php

namespace Tests\Unit;

use App\Thread;
use App\Activity;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $this->assertDatabaseHas('activities', [
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread',
            'type' => 'created_thread',
        ]);

        $activity = Activity::first();
        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->assertEquals(2, Activity::count());
    }

    /** @test */
    public function it_fetches_a_feed_for_any_user()
    {
        // given we have a Thread
        $this->signIn();
        // create 2 thread
        create('App\Thread', ['user_id' => auth()->id()], 2);
        // and another thread from a weak ago
        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);
        create('App\Thread', [
            'user_id' => auth()->id(),
            'created_at' => Carbon::now()->subWeek()
        ]);
        // when we fetch their feed
        $feed = Activity::feed(auth()->user());
        // then, it should be returned in the proper format
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
