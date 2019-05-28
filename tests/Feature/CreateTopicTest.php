<?php

namespace Tests\Feature;

use App\Models\Topic;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTopicTest extends TestCase
{
    /**
     * 測試用戶發表文章
     * @test
     */
    public function user_can_create_topic()
    {
        $this->be($user = User::find(1));
        $topic = factory(Topic::class)
            ->make(['user_id' => $user->id, 'category_id' => 1]);

        $result = $this->post(route('topics.store'), $topic->toArray());
        $this->get($result->getTargetUrl())->assertOk();
    }

    /**
     * 測試訪客禁止發表文章
     * @test
     */
    public function guest_can_store_topic()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $topic = factory(Topic::class)
            ->make(['category_id' => 1]);

        $result = $this->post(route('topics.store'), $topic->toArray());
        $this->get($result->getTargetUrl())->assertOk();
    }
}
