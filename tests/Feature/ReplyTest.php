<?php

namespace Tests\Feature;

use App\Models\Topic;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    protected $topic;

    public function setUp()
    {
        parent::setUp();
        $this->topic = Topic::inRandomOrder()->first();
    }

    /**
     * reply 的 user 關聯是否為 App\Models\User 的實例
     */
    public function test_reply_owner()
    {
        // 學習斷言 assertInstanceOf 用的，移除測試僅供檢視
        $this->markTestSkipped();

        $reply = $this->topic->replies()->orderByRaw("RAND()")->first();

        $this->assertInstanceOf('App\Models\User', $reply->user);
    }
}
