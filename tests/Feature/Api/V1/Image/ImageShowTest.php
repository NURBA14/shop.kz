<?php

namespace Tests\Feature\Api\V1\Image;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImageShowTest extends TestCase
{
    use RefreshDatabase;

    private static $image;
    private static $product;
    public function setUp(): void
    {
        parent::setUp();
        $category = Category::factory()->createOne();
        $brand = Brand::factory()->createOne();
        self::$product = Product::factory()->for(User::factory())->createOne([
            "brand_id" => $brand->id,
            "category_id" => $category->id,
        ]);
        self::$image = Image::factory()->createOne([
            "product_id" => self::$product->id
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/api/v1/images/' . self::$image->id);
        $response->assertJsonStructure([
            "image" => [
                "id",
                "url",
                "product" => [
                    "id",
                    "name",
                    "description",
                    "price",
                    "count",
                    "brand",
                    "category",
                    "user" => [
                        "id",
                        "name"
                    ]
                ],
                "created_at"
            ]
        ]);
        $response->assertJson([
            "image" => [
                "id" => self::$image->id,
                "url" => self::$image->url,
                "product" => [
                    "id" => self::$product->id,
                    "name" => self::$product->name,
                    "description" => self::$product->description,
                    "price" => self::$product->price,
                    "count" => self::$product->count,
                    "brand" => self::$product->brand->name,
                    "category" => self::$product->category->name,
                    "user" => [
                        "id" => self::$product->user->id,
                        "name" => self::$product->user->name,
                    ],
                ],
                "created_at" => self::$image->created_at
            ]
        ]);
        $response->assertStatus(200);
    }
}
