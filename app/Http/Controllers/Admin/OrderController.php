<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('admin.orders.index', [
            'orders' => Order::with('items.product')->latest()->paginate(15),
        ]);
    }

    public function show(Order $order): View
    {
        $order->load('items.product');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,shipped,delivered,cancelled'],
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated.');
    }
}
