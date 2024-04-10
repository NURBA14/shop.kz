<?php

namespace Tests\Feature\Api\V1\Product;

use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    private static $user;
    private static $token;
    private static $brand;
    private static $category;
    private static $product;
    public function setUp(): void
    {
        parent::setUp();
        self::$user = User::factory()->createOne(["is_admin" => 1]);
        self::$brand = Brand::factory()->createOne();
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

    public function test_create_product()
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->post('/api/v1/products', [
                    "name" => "name",
                    "description" => "des",
                    "price" => 100.0,
                    "count" => 100,
                    "brand_id" => self::$brand->id,
                    "category_id" => self::$category->id,
                    "is_active" => 1
                ]);
        $response->assertJsonStructure([
            "product" => [
                "id",
                "name",
                "description",
                "price",
                "count",
                "rating",
                "brand",
                "category",
                "user" => [
                    "id",
                    "name"
                ],
                "created_at",
                "images" => [],
                "reviews"
            ]
        ]);
        self::$product = $response->json("product");
        $response->assertStatus(201);
    }

    public function test_update_product_put()
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->put("/api/v1/products/" . self::$product["id"], [
            "name" => "New Name",
            "description" => "des",
            "price" => 100.0,
            "count" => 100,
            "is_active" => 1,
            "brand_id" => self::$brand->id,
            "category_id" => self::$category->id
        ]);
        $response->assertJsonStructure([
            "product" => [
                "id",
                "name",
                "description",
                "price",
                "count",
                "rating",
                "brand",
                "category",
                "user" => [
                    "id",
                    "name"
                ],
                "created_at",
                "images" => [],
                "reviews"
            ]
        ]);
        $response->assertOk();
    }


    public function test_product_update_patch()
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->patch("/api/v1/products/" . self::$product["id"], [
            "name" => "New Name",
        ]);
        $response->assertJsonStructure([
            "product" => [
                "id",
                "name",
                "description",
                "price",
                "count",
                "rating",
                "brand",
                "category",
                "user" => [
                    "id",
                    "name"
                ],
                "created_at",
                "images" => [],
                "reviews"
            ]
        ]);
        $response->assertOk();
    }

    public function test_product_delete()
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->delete("/api/v1/products/" . self::$product["id"]);
        $response->assertJson([
            "message" =>"success"
        ]);
        $response->assertOk();
    }

}
