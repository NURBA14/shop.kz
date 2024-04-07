<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::factory(5)->create();
        Category::factory(5)->create();
        User::factory(10)->create();
        Product::factory(10)->create();
        Image::factory(20)->create();
        Review::factory(20)->create();
    }
}
