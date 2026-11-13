<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MiniShop | Everyday finds</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    <header class="sticky top-0 z-10 border-b border-slate-200 bg-white/95 backdrop-blur">
        <nav class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-5 py-4 lg:px-8" aria-label="Main navigation">
            <a href="/" class="text-2xl font-black tracking-tight text-indigo-700">MiniShop<span class="text-blue-500">.</span></a>

            <div class="hidden items-center gap-7 md:flex">
                <a href="{{ route('home') }}" class="text-sm font-medium {{ $selectedCategoryId === null ? 'text-indigo-700 font-bold' : 'text-slate-600' }} transition hover:text-indigo-700">All Products</a>
                @foreach ($categories as $category)
                    <a href="{{ route('home', ['category' => $category->id]) }}" class="text-sm {{ $selectedCategoryId == $category->id ? 'font-bold text-indigo-700' : 'font-medium text-slate-600' }} transition hover:text-indigo-700">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <a href="{{ route('cart.index') }}" aria-label="Shopping cart" class="relative inline-flex size-10 items-center justify-center rounded-full border border-slate-200 text-slate-700 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l2.2 10.1a2 2 0 0 0 2 1.6h8.5a2 2 0 0 0 1.9-1.4L21 8H6" />
                    <circle cx="10" cy="20" r="1" /><circle cx="18" cy="20" r="1" />
                </svg>
                <span id="cart-count" class="absolute -right-1 -top-1 inline-flex min-w-5 items-center justify-center rounded-full bg-indigo-700 px-1.5 py-0.5 text-xs font-bold text-white {{ $cartCount > 0 ? '' : 'hidden' }}">{{ $cartCount }}</span>
            </a>
        </nav>
        <div class="flex gap-5 overflow-x-auto px-5 pb-3 md:hidden">
            <a href="{{ route('home') }}" class="shrink-0 text-sm {{ $selectedCategoryId === null ? 'font-bold text-indigo-700' : 'font-medium text-slate-600' }}">All Products</a>
            @foreach ($categories as $category)
                <a href="{{ route('home', ['category' => $category->id]) }}" class="shrink-0 text-sm {{ $selectedCategoryId == $category->id ? 'font-bold text-indigo-700' : 'font-medium text-slate-600' }}">{{ $category->name }}</a>
            @endforeach
        </div>
    </header>

    <main>
        @if (session('error'))
            <div role="alert" class="mx-auto mt-6 max-w-7xl px-5 lg:px-8">
                <p class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-medium text-amber-900">{{ session('error') }}</p>
            </div>
        @endif
        <section class="overflow-hidden bg-indigo-700 text-white">
            <div class="mx-auto grid max-w-7xl gap-10 px-5 py-16 md:grid-cols-[1.2fr_0.8fr] md:items-center md:py-24 lg:px-8">
                <div>
                    <p class="mb-4 text-sm font-bold uppercase tracking-[0.18em] text-indigo-200">A little something for every day</p>
                    <h1 class="max-w-xl text-4xl font-black leading-tight sm:text-5xl">Welcome to MiniShop</h1>
                    <p class="mt-5 max-w-lg text-lg leading-8 text-indigo-100">Good finds, fair prices, and the small things that make everyday life better.</p>
                    <a href="#products" class="mt-8 inline-flex items-center rounded-full bg-white px-6 py-3 text-sm font-bold text-indigo-800 transition hover:bg-indigo-50">Explore the collection <span class="ml-2" aria-hidden="true">&darr;</span></a>
                </div>
                <div class="hidden justify-end md:flex" aria-hidden="true">
                    <div class="grid size-64 grid-cols-2 gap-3 rotate-3">
                        <div class="rounded-3xl bg-blue-400"></div>
                        <div class="mt-8 rounded-3xl bg-indigo-400"></div>
                        <div class="-mt-8 rounded-3xl bg-sky-300"></div>
                        <div class="rounded-3xl bg-white/20"></div>
                    </div>
                </div>
            </div>
        </section>

        <div id="products" class="mx-auto max-w-7xl px-5 py-14 lg:px-8 lg:py-16">
            <div class="mb-10 flex items-end justify-between gap-4">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.16em] text-indigo-600">The MiniShop edit</p>
                    <h2 class="mt-2 text-3xl font-black tracking-tight">Find your next favorite</h2>
                </div>
                <span class="hidden text-sm text-slate-500 sm:block">{{ $products->count() }} items to explore</span>
            </div>

            @if ($products->isEmpty())
                <p class="rounded-xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center text-slate-500">{{ $selectedCategoryId !== null ? 'No products in this category' : 'No products to show yet.' }}</p>
            @else
                @foreach ($categories as $category)
                    @php($categoryProducts = $products->where('category_id', $category->id))
                    @if ($categoryProducts->isNotEmpty())
                        <section id="category-{{ $category->slug }}" class="mb-14 scroll-mt-32 last:mb-0">
                            <h3 class="mb-5 text-xl font-bold">{{ $category->name }}</h3>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach ($categoryProducts as $product)
                                    <article class="group relative isolate overflow-hidden rounded-2xl border border-slate-200 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/70">
                                        <a href="{{ route('products.show', $product->slug) }}" aria-label="View {{ $product->name }}" class="absolute inset-0 z-10 rounded-2xl focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"></a>
                                        <div class="pointer-events-none relative z-0 aspect-[4/3] overflow-hidden bg-slate-100">
                                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="size-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                                        </div>
                                        <div class="pointer-events-none relative z-20 p-5">
                                            <p class="text-xs font-bold uppercase tracking-wider text-indigo-600">{{ $product->category->name }}</p>
                                            <h4 class="mt-2 text-lg font-bold">{{ $product->name }}</h4>
                                            <div class="mt-5 flex items-center justify-between gap-3">
                                                <span class="text-xl font-black text-slate-900">${{ number_format((float) $product->price, 2) }}</span>
                                                <form action="{{ route('cart.add', $product) }}" method="POST" data-add-to-cart class="pointer-events-auto relative z-20">
                                                    @csrf
                                                    <button type="submit" class="rounded-full bg-indigo-700 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Add to Cart</button>
                                                </form>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif
                @endforeach
            @endif
        </div>
    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-5 py-6 text-sm text-slate-500 lg:px-8">&copy; {{ date('Y') }} MiniShop</div>
    </footer>
    <div id="cart-toast" class="fixed right-5 top-5 z-50 hidden rounded-lg bg-emerald-700 px-4 py-3 text-sm font-semibold text-white shadow-lg" role="status" aria-live="polite"></div>
    <script>
        const cartCount = document.getElementById('cart-count');
        const cartToast = document.getElementById('cart-toast');
        let toastTimeout;

        function showCartToast(message, isError = false) {
            cartToast.textContent = message;
            cartToast.classList.toggle('bg-emerald-700', !isError);
            cartToast.classList.toggle('bg-red-700', isError);
            cartToast.classList.remove('hidden');
            clearTimeout(toastTimeout);
            toastTimeout = setTimeout(() => cartToast.classList.add('hidden'), 2000);
        }

        document.querySelectorAll('[data-add-to-cart]').forEach((form) => {
            form.addEventListener('click', (event) => event.stopPropagation());
            form.addEventListener('submit', async (event) => {
                event.preventDefault();
                const button = form.querySelector('button[type="submit"]');
                button.disabled = true;

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: new FormData(form),
                    });

                    if (!response.ok) {
                        throw new Error('Cart request failed');
                    }

                    cartCount.textContent = Number(cartCount.textContent) + 1;
                    cartCount.classList.remove('hidden');
                    showCartToast('Product added to cart!');
                } catch (error) {
                    showCartToast('Failed to add product', true);
                } finally {
                    button.disabled = false;
                }
            });
        });
    </script>
</body>
</html>