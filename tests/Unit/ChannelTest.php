<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Topic;
use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelTest extends TestCase
{
    protected $thread;
    protected $topic; // 用 Topic 關聯 reply 做測試
    protected $channel;

    public function setUp()
    {
        parent::setUp();
        // Thread 的 channle id 有效範圍
        $this->channel = Channel::query()->whereBetween('id',[20, 30])->inRandomOrder()->first();
    }

    /** @test */
    public function a_channel_consists_of_threads()
    {
        $channel = $this->channel;
        $thread = Thread::where('channel_id', $this->channel->id)->first();

        $this->assertTrue($channel->threads->contains($thread));
    }
}
