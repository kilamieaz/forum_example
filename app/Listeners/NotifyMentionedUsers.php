<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use App\User;
use App\Notifications\YouWereMentioned;

class NotifyMentionedUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        // inspect the body of the reply for username mentions
        preg_match_all('/\@([^\s\.]+)/', $event->reply->body, $matches);
        // and then for each mentioned user, notify them.
        foreach ($matches[1] as $name) {
            $user = User::whereName($name)->first();
            if ($user) {
                $user->notify(new YouWereMentioned($event->reply));
            }
        }
    }
}
