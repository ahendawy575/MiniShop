<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} | MiniShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    <header class="border-b border-slate-200 bg-white">
        <nav class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-5 py-4 lg:px-8" aria-label="Main navigation">
            <a href="{{ route('home') }}" class="text-2xl font-black tracking-tight text-indigo-700">MiniShop<span class="text-blue-500">.</span></a>
            <a href="{{ route('cart.index') }}" aria-label="Shopping cart" class="relative inline-flex size-10 items-center justify-center rounded-full border border-slate-200 text-slate-700 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l2.2 10.1a2 2 0 0 0 2 1.6h8.5a2 2 0 0 0 1.9-1.4L21 8H6" />
                    <circle cx="10" cy="20" r="1" /><circle cx="18" cy="20" r="1" />
                </svg>
                <span id="cart-count" class="absolute -right-1 -top-1 inline-flex min-w-5 items-center justify-center rounded-full bg-indigo-700 px-1.5 py-0.5 text-xs font-bold text-white {{ $cartCount > 0 ? '' : 'hidden' }}">{{ $cartCount }}</span>
            </a>
        </nav>
    </header>

    <main class="mx-auto max-w-7xl px-5 py-8 lg:px-8 lg:py-12">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-2.5 text-sm font-bold text-slate-700 transition hover:border-indigo-200 hover:text-indigo-700">
            <span aria-hidden="true">&larr;</span> Back to Home
        </a>

        @if (session('error'))
            <p role="alert" class="mt-6 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-medium text-amber-900">{{ session('error') }}</p>
        @endif
        @if ($errors->any())
            <p role="alert" class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">{{ $errors->first('quantity') }}</p>
        @endif

        <section class="mt-8 grid gap-10 lg:grid-cols-[0.8fr_1.2fr] lg:items-center lg:gap-14">
            <div class="order-2 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm lg:order-2">
                @if ($product->image)
                    <img src="{{ Str::startsWith($product->image, ['http://', 'https://']) ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="aspect-[4/3] size-full object-cover">
                @else
                    <div class="flex aspect-[4/3] items-center justify-center bg-gradient-to-br from-indigo-100 to-sky-100 text-indigo-400" aria-label="No product image available">
                        <svg class="size-20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m3 16 5-5 4 4 3-3 6 6M5 20h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z" />
                            <circle cx="8.5" cy="8.5" r="1.5" />
                        </svg>
                    </div>
                @endif
            </div>

            <div class="order-1 lg:order-1">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-indigo-600">{{ $product->category->name }}</p>
                <h1 class="mt-3 text-4xl font-black tracking-tight sm:text-5xl">{{ $product->name }}</h1>
                <p class="mt-5 text-3xl font-black text-indigo-700">${{ number_format((float) $product->price, 2) }}</p>
                <p class="mt-6 whitespace-pre-line leading-7 text-slate-600">{{ $product->description ?: 'Discover this MiniShop favorite, selected to make everyday life a little better.' }}</p>

                @if ($product->stock > 0)
                    <p class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-emerald-700">
                        <span class="size-2 rounded-full bg-emerald-500"></span> In Stock ({{ $product->stock }} available)
                    </p>
                @else
                    <p class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-red-700">
                        <span class="size-2 rounded-full bg-red-500"></span> Out of Stock
                    </p>
                @endif

                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-7 flex flex-wrap items-end gap-4">
                    @csrf
                    <div>
                        <label for="quantity" class="mb-2 block text-sm font-bold text-slate-700">Quantity</label>
                        <input id="quantity" name="quantity" type="number" value="{{ old('quantity', 1) }}" min="1" max="{{ $product->stock }}" required @disabled($product->stock < 1) class="w-24 rounded-xl border border-slate-300 bg-white px-3 py-3 text-center font-semibold focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 disabled:bg-slate-100">
                    </div>
                    <button type="submit" @disabled($product->stock < 1) class="rounded-full bg-indigo-700 px-7 py-3 text-sm font-bold text-white transition hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:bg-slate-400">Add to Cart</button>
                </form>
            </div>
        </section>

        @if ($relatedProducts->isNotEmpty())
            <section class="mt-16 border-t border-slate-200 pt-12">
                <div class="mb-7">
                    <p class="text-sm font-bold uppercase tracking-[0.16em] text-indigo-600">More to explore</p>
                    <h2 class="mt-2 text-3xl font-black tracking-tight">Related Products</h2>
                </div>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($relatedProducts as $relatedProduct)
                        <a href="{{ route('products.show', $relatedProduct->slug) }}" class="group overflow-hidden rounded-2xl border border-slate-200 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/70">
                            <div class="aspect-[4/3] overflow-hidden bg-slate-100">
                                @if ($relatedProduct->image)
                                    <img src="{{ Str::startsWith($relatedProduct->image, ['http://', 'https://']) ? $relatedProduct->image : asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}" class="size-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                                @else
                                    <div class="size-full bg-gradient-to-br from-indigo-100 to-sky-100"></div>
                                @endif
                            </div>
                            <div class="p-5">
                                <p class="text-xs font-bold uppercase tracking-wider text-indigo-600">{{ $relatedProduct->category->name }}</p>
                                <h3 class="mt-2 text-lg font-bold">{{ $relatedProduct->name }}</h3>
                                <p class="mt-4 text-xl font-black">${{ number_format((float) $relatedProduct->price, 2) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </main>

    <footer class="mt-16 border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-5 py-6 text-sm text-slate-500 lg:px-8">&copy; {{ date('Y') }} MiniShop</div>
    </footer>
</body>
</html>
