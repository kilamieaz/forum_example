<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;
use App\Events\ThreadReceivedNewReply;

class NotifyThreadSubscribers
{
    /**
     * Handle the event.
     *
     * @param  ThreadHasNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        // prepare notifications for all subscribers
        $event->thread->notifySubscribers($event->reply);
    }
}
