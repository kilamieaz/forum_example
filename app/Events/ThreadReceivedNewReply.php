<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class ThreadReceivedNewReply
{
    use SerializesModels;
    // var $thread, $reply;
    public $thread;
    public $reply;

    public function __construct($thread, $reply)
    {
        $this->thread = $thread;
        $this->reply = $reply;
    }
}
