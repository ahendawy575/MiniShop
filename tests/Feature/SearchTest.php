<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_search_returns_products_with_matching_names(): void
    {
        $category = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
        ]);
        Product::create([
            'category_id' => $category->id,
            'name' => 'Phone Case',
            'slug' => 'phone-case',
            'price' => 12.99,
            'stock' => 5,
        ]);
        Product::create([
            'category_id' => $category->id,
            'name' => 'Cotton T-Shirt',
            'slug' => 'cotton-t-shirt',
            'price' => 24.00,
            'stock' => 3,
        ]);

        $this->get('/?search=phone')
            ->assertOk()
            ->assertSee('Phone Case')
            ->assertDontSee('Cotton T-Shirt')
            ->assertSee('Showing results for:')
            ->assertSee('value="phone"', false);
    }

    public function test_home_page_search_shows_empty_results_message(): void
    {
        $this->get('/?search=xyz')
            ->assertOk()
            ->assertSee("No products found for 'xyz'", false);
    }

    public function test_home_page_search_can_be_combined_with_category_filter(): void
    {
        $selectedCategory = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
        ]);
        $otherCategory = Category::create([
            'name' => 'Home',
            'slug' => 'home',
        ]);
        Product::create([
            'category_id' => $selectedCategory->id,
            'name' => 'Phone Case',
            'slug' => 'phone-case',
            'price' => 12.99,
            'stock' => 5,
        ]);
        Product::create([
            'category_id' => $otherCategory->id,
            'name' => 'Phone Charger',
            'slug' => 'phone-charger',
            'price' => 9.99,
            'stock' => 4,
        ]);
        Product::create([
            'category_id' => $selectedCategory->id,
            'name' => 'Desk Lamp',
            'slug' => 'desk-lamp',
            'price' => 25.00,
            'stock' => 2,
        ]);

        $this->get('/?search=phone&category='.$selectedCategory->id)
            ->assertOk()
            ->assertSee('Phone Case')
            ->assertDontSee('Phone Charger')
            ->assertDontSee('Desk Lamp')
            ->assertSee('category='.$otherCategory->id.'&amp;search=phone', false);
    }
}
