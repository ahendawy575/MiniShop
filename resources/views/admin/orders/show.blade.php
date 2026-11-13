@extends('admin.layout')

@section('title', 'Order #'.$order->id)
@section('page-title', 'Order #'.$order->id)
@section('actions')
    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center border border-slate-300 bg-white px-4 py-2.5 text-sm font-bold text-slate-800 hover:bg-slate-50">Back to orders</a>
@endsection

@section('content')
    <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
        <div class="space-y-6">
            <section class="border border-slate-200 bg-white p-6">
                <h2 class="text-lg font-black">Customer details</h2>
                <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div><dt class="text-xs font-bold uppercase text-slate-500">Name</dt><dd class="mt-1 font-semibold">{{ $order->customer_name }}</dd></div>
                    <div><dt class="text-xs font-bold uppercase text-slate-500">Email</dt><dd class="mt-1 font-semibold">{{ $order->customer_email }}</dd></div>
                    <div><dt class="text-xs font-bold uppercase text-slate-500">Phone</dt><dd class="mt-1 font-semibold">{{ $order->customer_phone }}</dd></div>
                    <div><dt class="text-xs font-bold uppercase text-slate-500">Order date</dt><dd class="mt-1 font-semibold">{{ $order->created_at->format('M j, Y H:i') }}</dd></div>
                    <div class="sm:col-span-2"><dt class="text-xs font-bold uppercase text-slate-500">Address</dt><dd class="mt-1 whitespace-pre-line font-semibold">{{ $order->address }}</dd></div>
                </dl>
            </section>

            <section class="overflow-hidden border border-slate-200 bg-white">
                <div class="border-b border-slate-100 px-6 py-4"><h2 class="text-lg font-black">Products</h2></div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[500px] text-left text-sm">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                            <tr><th class="px-6 py-3 font-bold">Product</th><th class="px-6 py-3 font-bold">Price</th><th class="px-6 py-3 font-bold">Quantity</th><th class="px-6 py-3 text-right font-bold">Subtotal</th></tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="px-6 py-4 font-semibold">{{ $item->product->name }}</td>
                                    <td class="px-6 py-4">${{ number_format((float) $item->price, 2) }}</td>
                                    <td class="px-6 py-4">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-right font-semibold">${{ number_format((float) $item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t border-slate-200 bg-slate-50">
                            <tr><th colspan="3" class="px-6 py-4 text-right text-sm font-black">Order total</th><td class="px-6 py-4 text-right text-lg font-black">${{ number_format((float) $order->total, 2) }}</td></tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>

        <aside class="h-fit border border-slate-200 bg-white p-6">
            <h2 class="text-lg font-black">Order status</h2>
            <p class="mt-2 text-sm text-slate-600">Current status: <span class="font-bold capitalize text-slate-900">{{ $order->status }}</span></p>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="mt-5 space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label for="status" class="mb-2 block text-sm font-bold text-slate-700">Change status</label>
                    <select id="status" name="status" required class="w-full border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-emerald-500 focus:outline-none">
                        @foreach (['pending', 'shipped', 'delivered', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $order->status) === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full bg-emerald-500 px-4 py-3 text-sm font-bold text-slate-950 hover:bg-emerald-400">Update status</button>
            </form>
        </aside>
    </div>
@endsection
