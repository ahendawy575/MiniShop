<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | MiniShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    <div class="min-h-screen lg:grid lg:grid-cols-[250px_minmax(0,1fr)]">
        <aside class="bg-slate-950 text-slate-100 lg:min-h-screen">
            <div class="flex h-16 items-center justify-between border-b border-white/10 px-6">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-black">MiniShop <span class="text-emerald-400">/ Admin</span></a>
                <a href="{{ route('home') }}" class="text-xs font-semibold text-slate-400 hover:text-white">View store</a>
            </div>
            <nav class="flex gap-2 overflow-x-auto p-4 lg:block lg:space-y-1" aria-label="Admin navigation">
                <a href="{{ route('admin.dashboard') }}" class="block shrink-0 rounded-md px-4 py-3 text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-400 text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="block shrink-0 rounded-md px-4 py-3 text-sm font-semibold {{ request()->routeIs('admin.products.*') ? 'bg-emerald-400 text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Products</a>
                <a href="{{ route('admin.categories.index') }}" class="block shrink-0 rounded-md px-4 py-3 text-sm font-semibold {{ request()->routeIs('admin.categories.*') ? 'bg-emerald-400 text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Categories</a>
            </nav>
        </aside>

        <div class="min-w-0">
            <header class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-5 sm:px-8">
                <p class="text-sm font-bold text-slate-700">Store management</p>
                <span class="text-xs font-semibold uppercase text-slate-400">Admin</span>
            </header>
            <main class="mx-auto max-w-7xl p-5 sm:p-8">
                <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase text-emerald-700">MiniShop / Admin</p>
                        <h1 class="mt-1 text-2xl font-black tracking-tight sm:text-3xl">@yield('page-title')</h1>
                    </div>
                    @yield('actions')
                </div>

                @if (session('success'))
                    <div role="status" class="mb-5 border-l-4 border-emerald-500 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div role="alert" class="mb-5 border-l-4 border-rose-500 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-900">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>