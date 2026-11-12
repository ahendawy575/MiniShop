<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart | MiniShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    <header class="border-b border-slate-200 bg-white">
        <nav class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-5 py-4 lg:px-8" aria-label="Main navigation">
            <a href="{{ route('home') }}" class="text-2xl font-black tracking-tight text-indigo-700">MiniShop<span class="text-blue-500">.</span></a>
            <a href="{{ route('cart.index') }}" aria-label="Shopping cart" class="relative inline-flex size-10 items-center justify-center rounded-full border border-slate-200 text-slate-700">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l2.2 10.1a2 2 0 0 0 2 1.6h8.5a2 2 0 0 0 1.9-1.4L21 8H6" />
                    <circle cx="10" cy="20" r="1" /><circle cx="18" cy="20" r="1" />
                </svg>
                @if ($cartCount > 0)
                    <span class="absolute -right-1 -top-1 inline-flex min-w-5 items-center justify-center rounded-full bg-indigo-700 px-1.5 py-0.5 text-xs font-bold text-white">{{ $cartCount }}</span>
                @endif
            </a>
        </nav>
    </header>

    <main class="mx-auto max-w-7xl px-5 py-12 lg:px-8">
        <h1 class="mb-8 text-3xl font-black tracking-tight">Shopping Cart</h1>

        @if ($items->isEmpty())
            <section class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
                <p class="text-lg font-semibold text-slate-700">Cart is empty</p>
                <a href="{{ route('home') }}" class="mt-6 inline-flex rounded-full bg-indigo-700 px-6 py-3 text-sm font-bold text-white transition hover:bg-indigo-800">Continue Shopping</a>
            </section>
        @else
            <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white">
                <table class="w-full min-w-[640px] text-left">
                    <thead class="border-b border-slate-200 bg-slate-50 text-sm text-slate-600">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Product</th>
                            <th class="px-6 py-4 font-semibold">Price</th>
                            <th class="px-6 py-4 font-semibold">Quantity</th>
                            <th class="px-6 py-4 font-semibold">Total</th>
                            <th class="px-6 py-4"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($items as $item)
                            <tr>
                                <td class="px-6 py-5 font-semibold">{{ $item['product']->name }}</td>
                                <td class="px-6 py-5">${{ number_format((float) $item['product']->price, 2) }}</td>
                                <td class="px-6 py-5">
                                    <form action="{{ route('cart.update', $item['product']) }}" method="POST" class="flex items-start gap-2">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" required aria-label="Quantity for {{ $item['product']->name }}" class="w-20 rounded-lg border border-slate-300 px-3 py-2">
                                        <button type="submit" class="rounded-lg border border-indigo-200 px-3 py-2 text-sm font-semibold text-indigo-700 hover:bg-indigo-50">Update</button>
                                    </form>
                                    @error('quantity')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </td>
                                <td class="px-6 py-5 font-semibold">${{ number_format($item['subtotal'], 2) }}</td>
                                <td class="px-6 py-5 text-right">
                                    <form action="{{ route('cart.remove', $item['product']) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-700">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-col items-end gap-4">
                <p class="text-xl font-bold">Total: ${{ number_format($total, 2) }}</p>
                <a href="{{ route('checkout') }}" class="rounded-full bg-indigo-700 px-7 py-3 text-sm font-bold text-white transition hover:bg-indigo-800">Checkout</a>
            </div>
        @endif
    </main>
</body>
</html>
