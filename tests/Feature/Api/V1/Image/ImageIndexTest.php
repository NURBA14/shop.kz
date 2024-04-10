<?php

namespace Tests\Feature\Api\V1\Image;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImageIndexTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Brand::factory(5)->create();
        Category::factory(5)->create();
        $product = Product::factory()->for(User::factory())->createOne();
        Image::factory(100)->create([
            "product_id" => $product->id
        ]);
    }
    public function test_example(): void
    {
        $response = $this->get('/api/v1/images');
        $response->assertJsonStructure([
            "images" => [
                "*" => [
                    "id",
                    "url",
                    "product" => [
                        "id",
                        "name",
                        "price"
                    ],
                    "created_at"
                ]
            ]
        ]);
        $response->assertOk();
    }
}
