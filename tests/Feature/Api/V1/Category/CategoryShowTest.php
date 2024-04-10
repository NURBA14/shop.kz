<?php

namespace Tests\Feature\Api\V1\Category;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryShowTest extends TestCase
{
    use RefreshDatabase;
    private static $category;
    public function setUp(): void
    {
        parent::setUp();
        self::$category = Category::factory()->createOne();
        $brand = Brand::factory()->createOne();
        Product::factory(3)->for(User::factory())->create([
            "category_id" => self::$category->id,
            "brand_id" => $brand->id
        ]);
    }

    public function productsList()
    {
        return self::$category->products->map(fn($product) => [
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
    public function test_example(): void
    {
        $response = $this->get('/api/v1/categories/' . self::$category->id);
        $response->assertJsonStructure([
            "category" => [
                "id",
                "name",
                "created_at",
                "products_count",
                "products" => []
            ]
        ]);
        $response->assertJson([
            "category" => [
                "id" => self::$category->id,
                "name" => self::$category->name,
                "created_at" => self::$category->created_at,
                "products_count" => self::$category->getProductsCount(),
                "products" => $this->productsList()->toArray()
            ]
        ]);
        $response->assertStatus(200);
    }
}
