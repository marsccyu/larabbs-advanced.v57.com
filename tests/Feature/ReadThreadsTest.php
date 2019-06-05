<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Topic;
use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
//    use DatabaseMigrations;

    protected $thread;
    protected $topic; // 用 Topic 關聯 reply 做測試
    protected $channel;
    public function setUp()
    {
        parent::setUp();
        $this->thread = Thread::inRandomOrder()->first();
        $this->topic = Topic::query()->limit(1)->recent()->first();
        $this->channel = Channel::query()->where('id', $this->thread->channel_id)->first();
    }

    /**
     * 是否能顯示 thread 頁面及一則標題
     * @test
     */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')->assertSee($this->thread->title);
    }

    /**
     * 是否能顯示一則文章及對應標題
     * @test
     */
    public function a_user_can_read_a_single_thread()
    {
        $channel = Channel::where('id', $this->thread->channel_id)->first();
        $this->get(route('thread.show', [$channel->slug, $this->thread->id]))->assertSee($this->thread->title);
    }

    /**
     * 是否能顯示全部 Topic 及標題
     * @test
     */
    public function a_user_can_view_all_topics()
    {
        $this->get('topics')->assertSee($this->topic->title);
    }

    /**
     * 是否能顯示一則 Topic 內容及標題
     * @test
     */
    public function a_user_can_read_a_single_topic()
    {
        $this->get($this->topic->link())->assertSee($this->topic->title);
    }

    /**
     * 用 Topic 做測試關聯 reply
     * 是否能看到一則 Topic 其中的一則 reply
     * 有 Reply => 測試是否顯示
     * 沒有 Reply => 測試 0
     * @test
     */
    public function a_user_can_read_replies_that_are_associated_with_a_topic()
    {
        $count = 0;
        while ($count == 0) {
            $topic = Topic::query()->inRandomOrder()->first();
            $count = $topic->replies()->count();
        }

        if($count) {
            // 隨機取得一筆回復
            $reply = $topic->replies()->orderByRaw("RAND()")->first();
            $this->get($topic->link())->assertSee($reply->title);
        } else {
            $this->assertSame(0, $count);
        }
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = $this->channel;
        $threadInChannel = $this->thread;
        $threadNotInChannel = Thread::where('channel_id', '!=', $channel->id)->first();

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }
}
