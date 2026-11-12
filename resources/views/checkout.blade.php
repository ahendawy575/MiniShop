<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | MiniShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    <header class="border-b border-slate-200 bg-white">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8" aria-label="Main navigation">
            <a href="{{ route('home') }}" class="text-2xl font-black text-indigo-700">MiniShop<span class="text-blue-500">.</span></a>
            <a href="{{ route('cart.index') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-700">Back to cart</a>
        </nav>
    </header>

    <main class="mx-auto max-w-7xl px-5 py-10 lg:px-8 lg:py-14">
        <div class="mb-8">
            <p class="text-sm font-bold uppercase tracking-widest text-indigo-700">Almost there</p>
            <h1 class="mt-2 text-3xl font-black">Checkout</h1>
        </div>

        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_380px]">
            <form action="{{ route('checkout.place-order') }}" method="POST" class="rounded-xl border border-slate-200 bg-white p-6 sm:p-8">
                @csrf
                <h2 class="text-lg font-bold">Your details</h2>
                <div class="mt-6 grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="customer_name" class="mb-2 block text-sm font-semibold">Name</label>
                        <input id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required autocomplete="name" class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100">
                        @error('customer_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="customer_email" class="mb-2 block text-sm font-semibold">Email</label>
                        <input id="customer_email" type="email" name="customer_email" value="{{ old('customer_email') }}" required autocomplete="email" class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100">
                        @error('customer_email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="customer_phone" class="mb-2 block text-sm font-semibold">Phone</label>
                        <input id="customer_phone" type="tel" name="customer_phone" value="{{ old('customer_phone') }}" required autocomplete="tel" class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100">
                        @error('customer_phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="address" class="mb-2 block text-sm font-semibold">Address</label>
                        <textarea id="address" name="address" rows="4" required autocomplete="street-address" class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100">{{ old('address') }}</textarea>
                        @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <button type="submit" class="mt-7 inline-flex w-full items-center justify-center rounded-full bg-indigo-700 px-7 py-3.5 text-sm font-bold text-white transition hover:bg-indigo-800 sm:w-auto">Place Order</button>
            </form>

            <aside class="h-fit rounded-xl border border-slate-200 bg-white p-6">
                <h2 class="text-lg font-bold">Order summary</h2>
                <ul class="mt-5 divide-y divide-slate-200">
                    @foreach ($items as $item)
                        <li class="flex justify-between gap-4 py-4 text-sm">
                            <span class="text-slate-600">{{ $item['product']->name }} <span class="text-slate-400">× {{ $item['quantity'] }}</span></span>
                            <span class="shrink-0 font-semibold">${{ number_format($item['subtotal'], 2) }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-2 flex justify-between border-t border-slate-200 pt-5 text-lg font-black">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>