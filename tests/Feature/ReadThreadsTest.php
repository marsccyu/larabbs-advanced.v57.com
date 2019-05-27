<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\Topic;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
//    use DatabaseMigrations;

    protected $thread;
    protected $topic; // 用 Topic 關聯 reply 做測試
    public function setUp()
    {
        parent::setUp();
        $this->thread = Thread::inRandomOrder()->first();
        $this->topic = Topic::inRandomOrder()->first();
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
        $this->get($this->thread->path())->assertSee($this->thread->title);
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
     * @test
     */
    public function a_user_can_read_replies_that_are_associated_with_a_topic()
    {
        // 隨機取得一筆回復
        $reply = $this->topic->replies()->orderByRaw("RAND()")->first();
        $this->get($this->topic->link())->assertSee($reply->title);
    }
}
