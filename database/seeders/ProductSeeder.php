<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category' => 'electronics',
                'name' => 'Wireless Headphones',
                'slug' => 'wireless-headphones',
                'description' => 'Comfortable over-ear headphones with clear, balanced sound.',
                'price' => 79.99,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'category' => 'electronics',
                'name' => 'Classic Wristwatch',
                'slug' => 'classic-wristwatch',
                'description' => 'A minimalist everyday watch with a durable stainless-steel case.',
                'price' => 119.00,
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'category' => 'electronics',
                'name' => 'Portable Bluetooth Speaker',
                'slug' => 'portable-bluetooth-speaker',
                'description' => 'A compact wireless speaker made for music at home or on the go.',
                'price' => 49.50,
                'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'category' => 'fashion',
                'name' => 'Everyday Cotton T-Shirt',
                'slug' => 'everyday-cotton-t-shirt',
                'description' => 'A soft, breathable cotton tee with a relaxed everyday fit.',
                'price' => 24.00,
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'category' => 'fashion',
                'name' => 'Classic Running Sneakers',
                'slug' => 'classic-running-sneakers',
                'description' => 'Lightweight sneakers designed for comfortable daily wear.',
                'price' => 64.95,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'category' => 'fashion',
                'name' => 'Canvas Everyday Tote',
                'slug' => 'canvas-everyday-tote',
                'description' => 'A reusable canvas tote with room for daily essentials.',
                'price' => 18.50,
                'image' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'category' => 'home',
                'name' => 'Ceramic Table Lamp',
                'slug' => 'ceramic-table-lamp',
                'description' => 'A simple ceramic lamp that brings warm light to any room.',
                'price' => 55.00,
                'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'category' => 'home',
                'name' => 'Woven Throw Blanket',
                'slug' => 'woven-throw-blanket',
                'description' => 'A soft woven throw for adding comfort to your sofa or bed.',
                'price' => 42.00,
                'image' => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'category' => 'home',
                'name' => 'Indoor Decorative Plant',
                'slug' => 'indoor-decorative-plant',
                'description' => 'A low-maintenance green plant to brighten your living space.',
                'price' => 29.99,
                'image' => 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'category' => 'sports',
                'name' => 'Training Yoga Mat',
                'slug' => 'training-yoga-mat',
                'description' => 'A supportive, non-slip mat for stretching and floor workouts.',
                'price' => 35.00,
                'image' => 'https://images.unsplash.com/photo-1592432678016-e910b452f9a2?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'category' => 'sports',
                'name' => 'Insulated Sports Bottle',
                'slug' => 'insulated-sports-bottle',
                'description' => 'A reusable bottle that keeps drinks cool during your workout.',
                'price' => 22.50,
                'image' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'category' => 'sports',
                'name' => 'Training Dumbbell Set',
                'slug' => 'training-dumbbell-set',
                'description' => 'A versatile pair of dumbbells for strength training at home.',
                'price' => 89.00,
                'image' => 'https://images.unsplash.com/photo-1583454110551-21f2fa2afe61?auto=format&fit=crop&w=800&q=80',
            ],
        ];

        foreach ($products as $product) {
            $category = Category::where('slug', $product['category'])->firstOrFail();
            unset($product['category']);

            Product::updateOrCreate(
                ['slug' => $product['slug']],
                [
                    ...$product,
                    'category_id' => $category->id,
                    'stock' => 50,
                ],
            );
        }
    }
}
