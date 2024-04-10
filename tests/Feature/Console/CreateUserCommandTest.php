<?php

namespace Tests\Feature\Console;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserCommandTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_create_user_command(): void
    {
        $this->artisan("make:user")
            ->expectsQuestion("Enter name", fake()->name())
            ->expectsQuestion("Enter email", fake()->email())
            ->expectsQuestion("Enter password", "password")
            ->assertExitCode(0);
    }
}
