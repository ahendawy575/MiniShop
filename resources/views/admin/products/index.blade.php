@extends('admin.layout')

@section('title', 'Products')
@section('page-title', 'Products')
@section('actions')
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center bg-emerald-500 px-4 py-2.5 text-sm font-bold text-slate-950 hover:bg-emerald-400">Add product <span class="ml-2 text-lg" aria-hidden="true">+</span></a>
@endsection

@section('content')
    <div class="overflow-hidden border border-slate-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                    <tr><th class="px-5 py-4 font-bold">Product</th><th class="px-5 py-4 font-bold">Category</th><th class="px-5 py-4 font-bold">Price</th><th class="px-5 py-4 font-bold">Stock</th><th class="px-5 py-4 text-right font-bold">Actions</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-5 py-4"><p class="font-bold text-slate-900">{{ $product->name }}</p><p class="mt-1 max-w-sm truncate text-xs text-slate-500">{{ $product->description }}</p></td>
                            <td class="px-5 py-4 text-slate-600">{{ $product->category->name }}</td>
                            <td class="px-5 py-4 font-semibold">${{ number_format((float) $product->price, 2) }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $product->stock }}</td>
                            <td class="px-5 py-4"><div class="flex justify-end gap-3"><a href="{{ route('admin.products.edit', $product) }}" class="font-bold text-emerald-700 hover:text-emerald-900">Edit</a><form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">@csrf @method('DELETE')<button class="font-bold text-rose-700 hover:text-rose-900" type="submit">Delete</button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-12 text-center text-slate-500">No products yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-5">{{ $products->links() }}</div>
@endsection