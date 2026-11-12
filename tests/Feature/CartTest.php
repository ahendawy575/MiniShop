<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_product_can_be_added_to_the_session_cart(): void
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
            'stock' => 10,
        ]);

        $this->from('/')->post(route('cart.add', $product))
            ->assertRedirect('/');

        $this->assertSame([$product->id => 1], session('cart'));

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee('Headphones')
            ->assertSee('$49.99');

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('min-w-5')
            ->assertSee('>1</span>', false);
    }
}
