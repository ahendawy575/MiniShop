<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed | MiniShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen flex-col bg-slate-50 text-slate-900 antialiased">
    <header class="border-b border-slate-200 bg-white">
        <nav class="mx-auto flex w-full max-w-7xl items-center px-5 py-4 lg:px-8" aria-label="Main navigation">
            <a href="{{ route('home') }}" class="text-2xl font-black text-indigo-700">MiniShop<span class="text-blue-500">.</span></a>
        </nav>
    </header>
    <main class="mx-auto flex w-full max-w-3xl flex-1 items-center justify-center px-5 py-16">
        <section class="w-full border-y border-slate-200 py-12 text-center sm:py-16">
            <div class="mx-auto flex size-14 items-center justify-center rounded-full bg-emerald-100 text-emerald-700" aria-hidden="true">
                <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                </svg>
            </div>
            <h1 class="mt-6 text-3xl font-black">Thank you for your order!</h1>
            <p class="mt-3 text-slate-600">Your order number is <span class="font-bold text-slate-900">#{{ $order->id }}</span>.</p>
            <a href="{{ route('home') }}" class="mt-8 inline-flex rounded-full bg-indigo-700 px-7 py-3 text-sm font-bold text-white transition hover:bg-indigo-800">Continue Shopping</a>
        </section>
    </main>
</body>
</html>