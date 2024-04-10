<?php

namespace Tests\Feature\Api\V1\Brand;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandShowTest extends TestCase
{
    use RefreshDatabase;
    private static $brand;
    public function setUp(): void
    {
        parent::setUp();
        self::$brand = Brand::factory()->createOne();
        $category = Category::factory()->createOne();
        Product::factory(3)->for(User::factory())->create([
            "brand_id" => self::$brand->id,
            "category_id" => $category->id
        ]);
    }

    public function productsList()
    {
        return self::$brand->products->map(fn($product) => [
            "id" => $product->id,
            "name" => $product->name,
            "description" => $product->description,
            "price" => $product->price,
            "count" => $product->count,
            "rating" => $product->rating(),
            "brand" => $product->brand->name,
            "category" => $product->category->name,
            "created_at" => $product->created_at,
            "images" => $product->getImagesList(),
            "user" => [
                "id" => $product->user->id,
                "name" => $product->user->name,
            ]
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_brand_show(): void
    {
        $response = $this->get("/api/v1/brands/" . self::$brand->id);
        $response->assertJsonStructure([
            "brand" => [
                "id",
                "name",
                "created_at",
                "products_count",
                "products" => []
            ]
        ]);
        $response->assertJson([
            "brand" => [
                "id" => self::$brand->id,
                "name" => self::$brand->name,
                "created_at" => self::$brand->created_at,
                "products_count" => self::$brand->getProductsCount(),
                "products" => $this->productsList()->toArray()
            ]
        ]);
        $response->assertStatus(200);
    }
}
