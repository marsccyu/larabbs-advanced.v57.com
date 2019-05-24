<?php

namespace Tests\Feature;

use App\Models\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
//    use DatabaseMigrations;

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $thread = Thread::inRandomOrder()->first();

        $response = $this->get('/threads');
        $response->assertSee($thread->title);
    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        $thread = Thread::inRandomOrder()->first();

        $response = $this->get('/threads/' . $thread->id);
        $response->assertSee($thread->title);
    }
}
