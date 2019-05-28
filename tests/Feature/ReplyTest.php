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
     * 測試未登入是否能回復 Topic
     * @test
     */
    public function guest_can_view_replies_page()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post(route('replies.store'))->assertRedirect('/login');
    }

    /**
     * reply 的 user 關聯是否為 App\Models\User 的實例
     * 學習斷言 assertInstanceOf 用的，移除測試僅供檢視
     */
    public function test_reply_owner()
    {
        $this->markTestSkipped();

        $reply = $this->topic->replies()->orderByRaw("RAND()")->first();

        $this->assertInstanceOf('App\Models\User', $reply->user);
    }
}
