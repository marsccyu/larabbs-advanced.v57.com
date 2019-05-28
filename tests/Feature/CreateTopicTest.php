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
     * 測試未登入情況下訪問建立 Topic 頁面導向登入頁面
     * 測試未登入情況下建立 Topic 資料導向登入頁面
     * @test
     */
    public function guest_can_view_create_page()
    {
        $this->withExceptionHandling();

        $this->get(route('topics.create'))
            ->assertRedirect('/login');

        $this->post(route('topics.store'))
            ->assertRedirect('/login');

    }

    /**
     * 測試用戶發表文章
     * @test
     */
    public function user_can_create_topic()
    {
        $this->signIn($user = factory(User::class)->create());
        $topic = factory(Topic::class)
            ->make(['user_id' => $user->id, 'category_id' => 1]);

        $result = $this->post(route('topics.store'), $topic->toArray());
        $this->get($result->getTargetUrl())
            ->assertSee($topic->title)
            ->assertOk();
    }
}
