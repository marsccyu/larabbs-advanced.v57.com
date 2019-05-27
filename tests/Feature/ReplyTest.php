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
     * $test
     */
    public function test_reply_owner()
    {
        $reply = $this->topic->replies()->orderByRaw("RAND()")->first();

        $this->assertInstanceOf('App\Models\User', $reply->user);
    }
}
