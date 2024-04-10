<?php

namespace Tests\Feature\Api\V1\Product;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductShowTest extends TestCase
{
    use RefreshDatabase;
    private Product $product;
    public function setUp(): void
    {
        parent::setUp();
        $brand = Brand::factory()->createOne();
        $category = Category::factory()->createOne();
        $this->product = Product::factory()->for(User::factory())->createOne([
            "brand_id" => $brand->id,
            "category_id" => $category->id
        ]);        
        Review::factory(3)->for(User::factory())->create([
            "product_id" => $this->product->id
        ]);
        Image::factory(3)->create([
            "product_id" => $this->product->id
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_product_show(): void
    {
        $response = $this->get("/api/v1/products/{$this->product->id}");
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
                    "id", "name",
                ],
                "created_at",
                "images" => [],
                "reviews" => [
                    "*" => [
                        "id",
                        "text",
                        "rating",
                        "user" => [
                            "id",
                            "name"
                        ],
                        "created_at"
                    ]
                ]
            ]
        ]);
        $response->assertJson([
            "product" => [
                "id" => $this->product->id,
                "name" => $this->product->name,
                "description" => $this->product->description,
                "price" => $this->product->price,
                "count" => $this->product->count,
                "rating" => $this->product->rating(),
                "brand" => $this->product->brand->name,
                "category" => $this->product->category->name,
                "user" => [
                    "id" => $this->product->user->id,
                    "name" => $this->product->user->name,
                ],
                "created_at" => $this->product->created_at,
                "images" => $this->product->getImagesList(),
                "reviews" => $this->product->getReviews()->toArray()
            ]
        ]);
        $response->assertOk();
    }
}
