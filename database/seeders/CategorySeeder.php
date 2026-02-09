<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Lipstick', 'description' => 'Beautiful lip colors'],
            ['name' => 'Foundation', 'description' => 'Perfect base makeup'],
            ['name' => 'Mascara', 'description' => 'Enhance your lashes'],
            ['name' => 'Eyeshadow', 'description' => 'Stunning eye colors'],
            ['name' => 'Skincare', 'description' => 'Care for your skin'],
            ['name' => 'Perfume', 'description' => 'Lovely fragrances'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}
