<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'orderCount' => Order::count(),
            'salesTotal' => Order::sum('total'),
        ]);
    }
}
