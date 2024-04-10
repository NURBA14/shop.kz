<?php

namespace Tests\Feature\Api\V1\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    private static $user;
    private static $token;
    private static $category;
    public function setUp(): void
    {
        parent::setUp();
        self::$user = User::factory()->createOne(["is_admin" => 1]);
        self::$category = Category::factory()->createOne();
    }
    public function test_login()
    {
        $response = $this->post('/api/v1/login', [
            "email" => self::$user->email,
            "password" => "password"
        ]);
        self::$token = $response->json("token");
        $response->assertJsonStructure([
            "token"
        ]);
        $response->assertOk();
    }

    public function test_create_brand()
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->post('/api/v1/categories', [
                    "name" => "name",
                ]);
        $response->assertJsonStructure([
            "category" => [
                "id",
                "name",
                "created_at",
                "products_count",
                "products" => []
            ]
        ]);
        self::$category = $response->json("category");
        $response->assertStatus(201);
    }

    public function test_update_brand_put()
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->put("/api/v1/categories/" . self::$category["id"], [
            "name" => "New Name",
        ]);
        $response->assertJsonStructure([
            "category" => [
                "id",
                "name",
                "created_at",
                "products_count",
                "products" => []
            ]
        ]);
        $response->assertOk();
    }


    public function test_product_update_patch()
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->patch("/api/v1/categories/" . self::$category["id"], [
            "name" => "New Name",
        ]);
        $response->assertJsonStructure([
            "category" => [
                "id",
                "name",
                "created_at",
                "products_count",
                "products" => []
            ]
        ]);
        $response->assertOk();
    }

    public function test_product_delete()
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->delete("/api/v1/categories/" . self::$category["id"]);
        $response->assertJson([
            "message" =>"success"
        ]);
        $response->assertOk();
    }
}
