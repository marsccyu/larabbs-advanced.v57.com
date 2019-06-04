<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    public function index($channelSlug = null)
    {
        if($channelSlug){
            $channelId = Channel::where('slug',$channelSlug)->first()->id;
            $threads = Thread::where('channel_id',$channelId)->latest()->first();
            dd($threads->id);
        }else{
            $threads = Thread::latest()->get();
        }

        return view('threads.index',compact('threads'));
    }

    public function show(Thread $thread)
    {
        return view('threads.show',compact('thread'));
    }

}
