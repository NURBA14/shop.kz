<?php

namespace Tests\Feature\Api\V1\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogRegTest extends TestCase
{
    private $user = [
        "name" => "user 1",
        "email" => "muradnurbolat85@gmail.com",
        "password" => "password"
    ];
    /**
     * A basic feature test example.
     */
    public function test_register(): void
    {
        $response = $this->post('/api/v1/register', [
            "name" => $this->user["name"],
            "email" => $this->user["email"],
            "password" => $this->user["password"]
        ]);
        $response->assertJsonStructure([
            "message", "token"
        ]);
        $response->assertOk();
    }

    public function test_login()
    {
        $response = $this->post("/api/v1/login", [
            "email" => $this->user["email"],
            "password" => $this->user["password"]
        ]);
        $response->assertJsonStructure([
            "token"
        ]);
        $response->assertOk();
    }
}
