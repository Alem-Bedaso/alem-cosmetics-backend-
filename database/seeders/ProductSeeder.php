<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create a supplier user if none exists
        $supplier = User::where('role_id', 3)->first();
        if (!$supplier) {
            $supplier = User::create([
                'name' => 'Default Supplier',
                'email' => 'supplier@alem.com',
                'password' => bcrypt('password'),
                'role_id' => 3,
            ]);
        }

        $products = [
            [
                'name' => 'Matte Red Lipstick',
                'category' => 'Lipstick',
                'description' => 'Long-lasting matte red lipstick with rich color payoff. Perfect for all-day wear.',
                'price' => 850,
                'stock' => 50,
                'image' => '/lipsticks.jpg',
            ],
            [
                'name' => 'Pink Nude Lipstick',
                'category' => 'Lipstick',
                'description' => 'Soft pink nude shade for everyday elegance. Moisturizing formula.',
                'price' => 750,
                'stock' => 45,
                'image' => '/lipsticks.jpg',
            ],
            [
                'name' => 'HD Foundation',
                'category' => 'Foundation',
                'description' => 'Full coverage HD foundation for flawless skin. Available in multiple shades.',
                'price' => 1200,
                'stock' => 30,
                'image' => '/foundations.jpg',
            ],
            [
                'name' => 'Natural Glow Foundation',
                'category' => 'Foundation',
                'description' => 'Lightweight foundation with natural finish. SPF 15 protection.',
                'price' => 1100,
                'stock' => 35,
                'image' => '/foundations.jpg',
            ],
            [
                'name' => 'Volume Mascara',
                'category' => 'Mascara',
                'description' => 'Dramatic volume mascara for bold, beautiful lashes. Waterproof formula.',
                'price' => 650,
                'stock' => 60,
                'image' => '/mascaras.jpg',
            ],
            [
                'name' => 'Lengthening Mascara',
                'category' => 'Mascara',
                'description' => 'Extends lashes for a natural, elongated look. Smudge-proof.',
                'price' => 550,
                'stock' => 55,
                'image' => '/mascaras.jpg',
            ],
            [
                'name' => 'Nude Eyeshadow Palette',
                'category' => 'Eyeshadow',
                'description' => '12 stunning nude shades for versatile eye looks. Highly pigmented.',
                'price' => 1500,
                'stock' => 25,
                'image' => '/eyeshadow.jpg',
            ],
            [
                'name' => 'Smokey Eye Palette',
                'category' => 'Eyeshadow',
                'description' => 'Perfect for creating dramatic smokey eyes. Includes 10 shades.',
                'price' => 1400,
                'stock' => 28,
                'image' => '/eyeshadow.jpg',
            ],
            [
                'name' => 'Hydrating Face Serum',
                'category' => 'Skincare',
                'description' => 'Intensive hydration serum with hyaluronic acid. Suitable for all skin types.',
                'price' => 1800,
                'stock' => 40,
                'image' => '/skincare.jpg',
            ],
            [
                'name' => 'Anti-Aging Night Cream',
                'category' => 'Skincare',
                'description' => 'Rich night cream that reduces fine lines and wrinkles. Dermatologist tested.',
                'price' => 2200,
                'stock' => 32,
                'image' => '/skincare.jpg',
            ],
            [
                'name' => 'Rose Garden Perfume',
                'category' => 'Perfume',
                'description' => 'Elegant floral fragrance with notes of rose and jasmine. 50ml bottle.',
                'price' => 2800,
                'stock' => 20,
                'image' => '/perfumes.jpg',
            ],
            [
                'name' => 'Vanilla Dream Perfume',
                'category' => 'Perfume',
                'description' => 'Sweet and warm vanilla scent perfect for evening wear. 50ml bottle.',
                'price' => 2500,
                'stock' => 22,
                'image' => '/perfumes.jpg',
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('name', $productData['category'])->first();
            
            if ($category) {
                Product::create([
                    'name' => $productData['name'],
                    'slug' => Str::slug($productData['name']),
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock' => $productData['stock'],
                    'category_id' => $category->id,
                    'supplier_id' => $supplier->id,
                    'is_active' => true,
                    'images' => isset($productData['image']) ? [$productData['image']] : null,
                ]);
            }
        }
    }
}
