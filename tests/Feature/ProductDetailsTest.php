<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductDetailsTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_details_page_shows_product_name_and_price(): void
    {
        $category = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
        ]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Wireless Headphones',
            'slug' => 'wireless-headphones',
            'description' => 'Comfortable everyday headphones.',
            'price' => 49.99,
            'stock' => 5,
        ]);

        $this->get(route('products.show', $product->slug))
            ->assertOk()
            ->assertSee('Wireless Headphones')
            ->assertSee('$49.99')
            ->assertSee('Electronics')
            ->assertSee('In Stock');
    }

    public function test_product_details_page_shows_related_products_from_same_category(): void
    {
        $category = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
        ]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Headphones',
            'slug' => 'headphones',
            'price' => 49.99,
            'stock' => 5,
        ]);
        $relatedProduct = Product::create([
            'category_id' => $category->id,
            'name' => 'Bluetooth Speaker',
            'slug' => 'bluetooth-speaker',
            'price' => 29.99,
            'stock' => 3,
        ]);

        $this->get(route('products.show', $product->slug))
            ->assertOk()
            ->assertSee('Related Products')
            ->assertSee('Bluetooth Speaker');
    }
}
