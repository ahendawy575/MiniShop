@extends('admin.layout')

@section('title', 'Orders')
@section('page-title', 'Orders')

@section('content')
    <div class="overflow-hidden border border-slate-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                    <tr>
                        <th class="px-5 py-4 font-bold">Order #</th>
                        <th class="px-5 py-4 font-bold">Customer</th>
                        <th class="px-5 py-4 font-bold">Total</th>
                        <th class="px-5 py-4 font-bold">Status</th>
                        <th class="px-5 py-4 font-bold">Order date</th>
                        <th class="px-5 py-4 text-right font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-5 py-4 font-bold text-slate-900">#{{ $order->id }}</td>
                            <td class="px-5 py-4 text-slate-700">{{ $order->customer_name }}</td>
                            <td class="px-5 py-4 font-semibold">${{ number_format((float) $order->total, 2) }}</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold capitalize text-slate-700">{{ $order->status }}</span>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $order->created_at->format('M j, Y H:i') }}</td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="font-bold text-emerald-700 hover:text-emerald-900">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center text-slate-500">No orders yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-5">{{ $orders->links() }}</div>
@endsection
