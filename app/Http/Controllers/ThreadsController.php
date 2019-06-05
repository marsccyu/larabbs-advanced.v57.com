<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    public function index(Channel $channel)
    {
        if($channel->exists){
            $threads = $channel->threads()->latest()->get();
        }else{
            $threads = Thread::latest()->get();
        }

        return view('threads.index',compact('threads'));
    }

    public function show(Channel $channel, Thread $thread)
    {
        return view('threads.show',compact('thread'));
    }

}
