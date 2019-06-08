<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Http\Request;
use App\Filters\ThreadsFilters;

class ThreadsController extends Controller
{
    public function index(Channel $channel,ThreadsFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        return view('threads.index',compact('threads'));
    }

    protected function getThreads(Channel $channel, ThreadsFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        $threads = $threads->get();
        return $threads;
    }

    public function show(Channel $channel, Thread $thread)
    {
        return view('threads.show',compact('thread'));
    }

}
