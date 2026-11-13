<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $selectedCategoryId = $request->query('category');
        $productQuery = Product::with('category')->latest();

        if ($selectedCategoryId !== null) {
            $productQuery->where('category_id', $selectedCategoryId);
        }

        $products = $productQuery->get();
        $categories = Category::all();
        $cartCount = array_sum(session('cart', []));

        return view('home', compact('products', 'categories', 'cartCount', 'selectedCategoryId'));
    }
}
