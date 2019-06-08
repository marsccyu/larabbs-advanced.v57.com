<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfilesTest extends TestCase
{
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = User::where('id', 1)->first();
    }

    /** @test */
    public function a_user_has_a_profile()
    {
        $user = $this->user;

        $this->get("/profiles/{$user->id}")
            ->assertSee($user->name);
    }

    /** @test */
    public function profiles_display_all_threads_created_by_the_associated_user()
    {
        $user = $this->user;

        $thread = Thread::where('user_id', $user->id)->first();

        $this->get("/profiles/{$user->id}")
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
