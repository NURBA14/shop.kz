<?php

namespace Tests\Feature\Api\V1\Product;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductIndexTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        Product::factory(100)->for(User::factory())->for(Brand::factory())->for(Category::factory())->create();
    }
    /**
     * A basic feature test example.
     */
    public function test_products_index(): void
    {
        $response = $this->get("/api/v1/products");
        $response->assertJsonStructure([
            "products" => [
                "*" => [
                    "id",
                    "name",
                    "description",
                    "price",
                    "count",
                    "rating",
                    "brand",
                    "category",
                    "created_at",
                    "images" => [],
                    "user" => []
                ]
            ]
        ]);
        $response->assertOk();
    }
}
