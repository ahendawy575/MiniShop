<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_returns_successful_response(): void
    {
        $this->get('/')
            ->assertOk();
    }

    public function test_home_page_filters_products_by_category(): void
    {
        $selectedCategory = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
        ]);
        $otherCategory = Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
        ]);
        Product::create([
            'category_id' => $selectedCategory->id,
            'name' => 'Wireless Headphones',
            'slug' => 'wireless-headphones',
            'price' => 49.99,
            'stock' => 5,
        ]);
        Product::create([
            'category_id' => $otherCategory->id,
            'name' => 'Cotton T-Shirt',
            'slug' => 'cotton-t-shirt',
            'price' => 24.00,
            'stock' => 8,
        ]);

        $this->get('/?category='.$selectedCategory->id)
            ->assertOk()
            ->assertSee('Wireless Headphones')
            ->assertDontSee('Cotton T-Shirt');
    }

    public function test_home_page_shows_empty_state_for_unknown_category(): void
    {
        $this->get('/?category=999')
            ->assertOk()
            ->assertSee('No products in this category');
    }
}
