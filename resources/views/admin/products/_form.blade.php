<div class="grid gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
        <label for="name" class="mb-2 block text-sm font-bold">Name</label>
        <input id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required maxlength="255" class="w-full border border-slate-300 bg-white px-3 py-2.5 outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
        @error('name')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label for="description" class="mb-2 block text-sm font-bold">Description</label>
        <textarea id="description" name="description" rows="4" class="w-full border border-slate-300 bg-white px-3 py-2.5 outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="price" class="mb-2 block text-sm font-bold">Price</label>
        <input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $product->price ?? '') }}" required class="w-full border border-slate-300 bg-white px-3 py-2.5 outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
        @error('price')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="stock" class="mb-2 block text-sm font-bold">Stock</label>
        <input id="stock" name="stock" type="number" min="0" step="1" value="{{ old('stock', $product->stock ?? 0) }}" required class="w-full border border-slate-300 bg-white px-3 py-2.5 outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
        @error('stock')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="category_id" class="mb-2 block text-sm font-bold">Category</label>
        <select id="category_id" name="category_id" required class="w-full border border-slate-300 bg-white px-3 py-2.5 outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
            <option value="">Choose a category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) old('category_id', $product->category_id ?? '') === (string) $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        @if (isset($product) && $product->image)
            @php
                $imageUrl = \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://'])
                    ? $product->image
                    : \Illuminate\Support\Facades\Storage::disk('public')->url($product->image);
            @endphp
            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="mb-4 h-32 w-32 rounded-lg object-cover">
        @endif
        <label for="image" class="mb-2 block text-sm font-bold">Product image</label>
        <input id="image" name="image" type="file" accept="image/*" @if (! isset($product)) required @endif class="w-full border border-slate-300 bg-white px-3 py-2.5 outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
        @error('image')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
    </div>
</div>