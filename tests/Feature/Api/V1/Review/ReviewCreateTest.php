<?php

namespace Tests\Feature\Api\V1\Review;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewCreateTest extends TestCase
{
    private static $user;
    private static $token;
    private static $product;
    public function setUp(): void
    {
        parent::setUp();
        self::$user = User::factory()->createOne(["is_admin" => 1]);
        $category = Category::factory()->createOne();
        $brand = Brand::factory()->createOne();
        self::$product = Product::factory()->for(User::factory())->createOne([
            "brand_id" => $brand->id,
            "category_id" => $category->id
        ]);
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

    public function test_create_review()
    {
        $id = self::$product->id;
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->post("/api/v1/products/" . $id . "/review", [
                    "text" => "name",
                    "rating" => 10,
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
                "reviews" => []
            ]
        ]);
        $response->assertJson([
            "product" => [
                "id" => self::$product->id,
                "name" => self::$product->name,
                "description" => self::$product->description,
                "price" => self::$product->price,
                "count" => self::$product->count,
                "rating" => self::$product->rating(),
                "brand" => self::$product->brand->name,
                "category" => self::$product->category->name,
                "user" => [
                    "id" => self::$product->user->id,
                    "name" => self::$product->user->name
                ],
                "created_at" => self::$product->created_at,
                "images" => self::$product->getImagesList(),
                "reviews" => self::$product->getReviews()->toArray()
            ]
        ]);
        $response->assertStatus(200);
    }
}
