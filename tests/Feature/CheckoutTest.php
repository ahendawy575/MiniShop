<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_page_is_available_when_cart_has_products(): void
    {
        $product = $this->createProduct();

        $this->withSession(['cart' => [$product->id => 2]])
            ->get(route('checkout'))
            ->assertOk()
            ->assertSee('Checkout')
            ->assertSee('Headphones')
            ->assertSee('$99.98');
    }

    public function test_order_is_created_with_items_and_redirects_to_thank_you(): void
    {
        $product = $this->createProduct();

        $response = $this->withSession(['cart' => [$product->id => 2]])
            ->post(route('checkout.place-order'), [
                'customer_name' => 'Sam Customer',
                'customer_email' => 'sam@example.com',
                'customer_phone' => '555-0100',
                'address' => '123 Market Street',
            ]);

        $order = Order::query()->firstOrFail();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => null,
            'customer_name' => 'Sam Customer',
            'customer_email' => 'sam@example.com',
            'total' => 99.98,
            'status' => 'pending',
        ]);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 49.99,
        ]);
        $response->assertRedirect(route('thank-you', $order));
        $this->assertNull(session('cart'));

        $this->get(route('thank-you', $order))
            ->assertOk()
            ->assertSee('Thank you for your order!')
            ->assertSee('#'.$order->id);
    }

    public function test_checkout_requires_customer_details_and_a_valid_email(): void
    {
        $product = $this->createProduct();

        $this->withSession(['cart' => [$product->id => 1]])
            ->post(route('checkout.place-order'), [
                'customer_email' => 'not-an-email',
            ])
            ->assertSessionHasErrors([
                'customer_name',
                'customer_email',
                'customer_phone',
                'address',
            ]);
    }

    public function test_empty_cart_redirects_home_with_a_message(): void
    {
        $this->get(route('checkout'))
            ->assertRedirect('/home')
            ->assertSessionHas('error');
    }

    private function createProduct(): Product
    {
        $category = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
        ]);

        return Product::create([
            'category_id' => $category->id,
            'name' => 'Headphones',
            'slug' => 'headphones',
            'price' => 49.99,
            'stock' => 10,
        ]);
    }
}
