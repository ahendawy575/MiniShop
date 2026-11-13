@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <section class="border border-slate-200 bg-white p-6">
            <p class="text-sm font-semibold text-slate-500">Products</p>
            <p class="mt-3 text-4xl font-black">{{ number_format($productCount) }}</p>
            <a href="{{ route('admin.products.index') }}" class="mt-4 inline-block text-sm font-bold text-emerald-700 hover:text-emerald-900">Manage products &rarr;</a>
        </section>
        <section class="border border-slate-200 bg-white p-6">
            <p class="text-sm font-semibold text-slate-500">Total Orders</p>
            <p class="mt-3 text-4xl font-black">{{ number_format($orderCount) }}</p>
            <p class="mt-4 text-sm text-slate-500">Orders placed in the store</p>
        </section>
        <section class="border border-slate-200 bg-white p-6">
            <p class="text-sm font-semibold text-slate-500">Pending Orders</p>
            <p class="mt-3 text-4xl font-black">{{ number_format($pendingOrderCount) }}</p>
            <a href="{{ route('admin.orders.index') }}" class="mt-4 inline-block text-sm font-bold text-emerald-700 hover:text-emerald-900">Manage orders &rarr;</a>
        </section>
        <section class="border border-slate-200 bg-white p-6">
            <p class="text-sm font-semibold text-slate-500">Total sales</p>
            <p class="mt-3 text-4xl font-black">${{ number_format((float) $salesTotal, 2) }}</p>
            <p class="mt-4 text-sm text-slate-500">Combined order totals</p>
        </section>
    </div>

    <div class="mt-8 flex flex-wrap gap-3">
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center bg-slate-950 px-4 py-3 text-sm font-bold text-white hover:bg-slate-800">Add product</a>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center border border-slate-300 bg-white px-4 py-3 text-sm font-bold text-slate-800 hover:bg-slate-50">Add category</a>
    </div>
@endsection