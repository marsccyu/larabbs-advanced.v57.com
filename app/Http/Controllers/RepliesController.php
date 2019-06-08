<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(ReplyRequest $request, Reply $reply)
    {
        $reply->user_id = Auth::id();
        $reply->content = $request->input('content');
        $reply->topic_id = $request->input('topic_id');
        $reply->body = 'Body'; // PHPunit Test 用到的填充數據
        $reply->save();

        return redirect()->to($reply->topic->link())->with('success', '評論送出成功！');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('destroy', $reply);
        $reply->delete();

        return redirect()->to($reply->topic->link())->with('success', 'Deleted！');
    }
}
