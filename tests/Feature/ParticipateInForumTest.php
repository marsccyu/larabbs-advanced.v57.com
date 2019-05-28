<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Topic;
use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    protected $thread;
    protected $topic; // 用 Topic 關聯 reply 做測試
    protected $reply;

    public function setUp()
    {
        parent::setUp();
        $this->thread = Thread::inRandomOrder()->first();
        $this->topic = Topic::inRandomOrder()->first();
        $this->reply = $this->topic->replies()->orderByRaw("RAND()")->first();
    }

    /**
     * 是否能夠回復一則 topic
     * @test
     */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn($user = factory(User::class)->create()); // 測試的應用程序登入

        // 產生 replies
        $replys = factory(Reply::class)
            ->times(1)
            ->make(['topic_id'=> $this->topic->id]);

        $this->post( route('replies.store'), $replys->first()->toArray() );

        $this->get($this->topic->link())
            ->assertSee($replys->first()->content);
    }

    /**
     * 未登入情況回復 Topic (預期拋出 AuthenticationException 錯誤）
     * @test
     */
    public function unauthenticated_user_may_no_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $replys = factory(Reply::class)
            ->make(['topic_id'=>$this->topic->id]);

        $this->post(route('replies.store'), $replys->first()->toArray());
    }
}
