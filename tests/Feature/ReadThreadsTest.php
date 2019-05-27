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

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        $this->get('/threads/' . $this->thread->id)->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_all_topics()
    {
        $this->get('topics')->assertSee($this->topic->title);
    }

    /** @test */
    public function a_user_can_read_a_single_topic()
    {
        $this->get('/topics/' . $this->topic->id)->assertSee($this->topic->title);
    }

    /**
     * @test
     * 我用 Topic 做測試關聯 reply
     */
    public function a_user_can_read_replies_that_are_associated_with_a_topic()
    {
        // 隨機取得一筆回復
        $reply = $this->topic->replies()->orderByRaw("RAND()")->first();
        $this->get(route('topics.show', ['topic' => $this->topic->id]))->assertSee($reply->title);
    }
}
