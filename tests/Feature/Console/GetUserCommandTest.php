<?php

namespace Tests\Feature\Console;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUserCommandTest extends TestCase
{
    use RefreshDatabase;
    private static $user;
    public function setUp(): void
    {
        parent::setUp();
        self::$user = User::factory()->createOne();
    }
    /**
     * A basic feature test example.
     */
    public function test_get_user_command(): void
    {
        $this->artisan("get:user")
        ->expectsQuestion("Enter User email", self::$user->email)
        ->assertExitCode(0);
    }
}
