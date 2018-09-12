<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPostCount()
    {
        $this->assertEquals(1, User::find(1)->withCount('posts')->first()->posts_count, 'Should exist 1 post');
    }
}
