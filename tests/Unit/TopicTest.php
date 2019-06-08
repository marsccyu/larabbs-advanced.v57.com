<?php

namespace Tests\Unit;

use App\Models\Topic;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopicTest extends TestCase
{
    protected $thread;
    protected $topic; // 用 Topic 關聯 reply 做測試
    protected $reply;

    public function setUp()
    {
        parent::setUp();
        $this->thread = Thread::inRandomOrder()->first();
        $this->topic = Topic::inRandomOrder()->first();
    }

    /**
     * topic 的 replies 關聯是否為 集合 實例
     * @test
     */
    public function a_topic_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->topic->replies);
    }

    /**
     * topic 的 user 關聯是否為 App\Models\User 實例
     * @test
     */
    public function a_topic_has_a_creator()
    {
        $this->assertInstanceOf('App\Models\User',$this->topic->user);
    }

    /** @test */
    function a_topci_belongs_to_a_channel()
    {
        $this->assertInstanceOf('App\Models\Channel',$this->topic->channel);
    }
}
