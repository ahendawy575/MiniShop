<?php

namespace Tests\Feature\Admin;

use App\Models\Order;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'admin.username' => 'shop-admin',
            'admin.password' => 'secret-password',
        ]);

        $this->withBasicAuth('shop-admin', 'secret-password');
    }

    public function test_admin_can_view_the_orders_list(): void
    {
        $this->createOrder();

        $this->get(route('admin.orders.index'))
            ->assertOk()
            ->assertSee('Orders')
            ->assertSee('Sam Customer');
    }

    public function test_admin_can_view_order_details(): void
    {
        $order = $this->createOrder();

        $this->get(route('admin.orders.show', $order))
            ->assertOk()
            ->assertSee('Sam Customer')
            ->assertSee('sam@example.com')
            ->assertSee('Headphones')
            ->assertSee('$99.98');
    }

    public function test_admin_can_update_an_order_status(): void
    {
        $order = $this->createOrder();

        $this->patch(route('admin.orders.update-status', $order), [
            'status' => 'shipped',
        ])->assertRedirect(route('admin.orders.show', $order));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'shipped',
        ]);
    }

    public function test_admin_cannot_set_an_order_to_an_invalid_status(): void
    {
        $order = $this->createOrder();

        $this->patch(route('admin.orders.update-status', $order), [
            'status' => 'processing',
        ])->assertSessionHasErrors('status');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'pending',
        ]);
    }

    private function createOrder(): Order
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

        $order = Order::create([
            'customer_name' => 'Sam Customer',
            'customer_email' => 'sam@example.com',
            'customer_phone' => '555-0100',
            'address' => '123 Market Street',
            'total' => 99.98,
            'status' => 'pending',
        ]);

        $order->orderItems()->create([
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 49.99,
        ]);

        return $order;
    }
}
