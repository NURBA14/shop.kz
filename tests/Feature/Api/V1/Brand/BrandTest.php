<?php

namespace Tests\Feature\Api\V1\Brand;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandTest extends TestCase
{
    private static $user;
    private static $token;
    private static $brand;
    public function setUp(): void
    {
        parent::setUp();
        self::$user = User::factory()->createOne(["is_admin" => 1]);
        self::$brand = Brand::factory()->createOne();
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
        ])->post('/api/v1/brands', [
                    "name" => "name",
                ]);
        $response->assertJsonStructure([
            "brand" => [
                "id",
                "name",
                "created_at",
                "products_count",
                "products" => []
            ]
        ]);
        self::$brand = $response->json("brand");
        $response->assertStatus(201);
    }

    public function test_update_brand_put()
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->put("/api/v1/brands/" . self::$brand["id"], [
            "name" => "New Name",
        ]);
        $response->assertJsonStructure([
            "brand" => [
                "id",
                "name",
                "created_at",
                "products_count",
                "products" => []
            ]
        ]);
        $response->assertOk();
    }


    public function test_update_brand_patch()
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->patch("/api/v1/brands/" . self::$brand["id"], [
            "name" => "New Name",
        ]);
        $response->assertJsonStructure([
            "brand" => [
                "id",
                "name",
                "created_at",
                "products_count",
                "products" => []
            ]
        ]);
        $response->assertOk();
    }

    public function test_brand_delete()
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->delete("/api/v1/brands/" . self::$brand["id"]);
        $response->assertJson([
            "message" =>"success"
        ]);
        $response->assertOk();
    }
}
