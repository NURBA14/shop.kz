<?php

namespace Tests\Feature\Api\V1\Brand;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandIndexTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        Brand::factory(100)->create();
    }
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/api/v1/brands');
        $response->assertJsonStructure([
            "brands" => [
                "*" => [
                    "id", "name", "products_count", "created_at"
                ]
            ]
        ]);
        $response->assertOk();
    }
}
