<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = session('cart', []);
        $products = Product::whereKey(array_keys($cart))->get()->keyBy('id');
        $items = $products->map(function (Product $product) use ($cart): array {
            $quantity = (int) ($cart[$product->id] ?? 0);

            return [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => (float) $product->price * $quantity,
            ];
        })->filter(fn (array $item): bool => $item['quantity'] > 0);
        $total = $items->sum('subtotal');
        $cartCount = array_sum($cart);

        return view('cart', compact('items', 'total', 'cartCount'));
    }

    public function checkout(Request $request): View|RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::whereKey(array_keys($cart))->get()->keyBy('id');
        $items = $products->map(function (Product $product) use ($cart): array {
            $quantity = (int) ($cart[$product->id] ?? 0);

            return [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => (float) $product->price * $quantity,
            ];
        })->filter(fn (array $item): bool => $item['quantity'] > 0);

        if ($items->isEmpty()) {
            return redirect()->route('home.page')->with('error', 'Your cart is empty. Add a product before checkout.');
        }

        $total = $items->sum('subtotal');

        return view('checkout', compact('items', 'total'));
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::whereKey(array_keys($cart))->get()->keyBy('id');
        $items = $products->map(function (Product $product) use ($cart): array {
            $quantity = (int) ($cart[$product->id] ?? 0);

            return [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
                'subtotal' => (float) $product->price * $quantity,
            ];
        })->filter(fn (array $item): bool => $item['quantity'] > 0);

        if ($items->isEmpty()) {
            return redirect()->route('home.page')->with('error', 'Your cart is empty. Add a product before checkout.');
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string'],
            'customer_email' => ['required', 'email'],
            'customer_phone' => ['required', 'string'],
            'address' => ['required', 'string'],
        ]);

        $order = DB::transaction(function () use ($validated, $items): Order {
            $order = Order::create([
                ...$validated,
                'user_id' => null,
                'total' => $items->sum('subtotal'),
                'status' => 'pending',
            ]);

            $order->orderItems()->createMany($items->map(fn (array $item): array => [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ])->all());

            return $order;
        });

        $request->session()->forget('cart');

        return redirect()->route('thank-you', $order);
    }

    public function thankYou(Order $order): View
    {
        return view('thank-you', compact('order'));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + 1;
        $request->session()->put('cart', $cart);

        return back();
    }

    public function remove(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$product->id]);
        $request->session()->put('cart', $cart);

        return back();
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);
        $cart = $request->session()->get('cart', []);
        $cart[$product->id] = (int) $validated['quantity'];
        $request->session()->put('cart', $cart);

        return back();
    }
}
