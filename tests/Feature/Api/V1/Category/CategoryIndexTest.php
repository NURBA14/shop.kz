<?php

namespace Tests\Feature\Api\V1\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryIndexTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        Category::factory(100)->create();
    }
    /**
     * A basic feature test example.
     */
    public function test_category_index(): void
    {
        $response = $this->get('/api/v1/categories');
        $response->assertJsonStructure([
            "categories" => [
                "*" => [
                    "id", "name", "products_count", "created_at"
                ]
            ]
        ]);
        $response->assertOk();
    }
}
