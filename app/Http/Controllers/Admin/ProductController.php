<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index', [
            'products' => Product::with('category')->latest()->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.products.create', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);
        $validated['image'] = $request->file('image')->store('products', 'public');
        $validated['slug'] = $this->uniqueSlug($validated['name']);

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);
        $validated['slug'] = $this->uniqueSlug($validated['name'], $product->id);

        $oldImage = $product->image;
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        if (isset($validated['image']) && $oldImage && ! Str::startsWith($oldImage, ['http://', 'https://'])) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name) ?: 'product';
        $slug = $baseSlug;
        $suffix = 2;

        while (Product::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $baseSlug.'-'.$suffix++;
        }

        return $slug;
    }
}
