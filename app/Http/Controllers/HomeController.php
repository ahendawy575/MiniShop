<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::all();
        $cartCount = array_sum(session('cart', []));

        return view('home', compact('products', 'categories', 'cartCount'));
    }
}