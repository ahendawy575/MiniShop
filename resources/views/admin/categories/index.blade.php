@extends('admin.layout')

@section('title', 'Categories')
@section('page-title', 'Categories')
@section('actions')
    <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center bg-emerald-500 px-4 py-2.5 text-sm font-bold text-slate-950 hover:bg-emerald-400">Add category <span class="ml-2 text-lg" aria-hidden="true">+</span></a>
@endsection

@section('content')
    <div class="overflow-hidden border border-slate-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[540px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-5 py-4 font-bold">Category</th><th class="px-5 py-4 font-bold">Products</th><th class="px-5 py-4 text-right font-bold">Actions</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-5 py-4"><p class="font-bold">{{ $category->name }}</p><p class="mt-1 text-xs text-slate-500">{{ $category->slug }}</p></td>
                            <td class="px-5 py-4 text-slate-600">{{ $category->products_count }}</td>
                            <td class="px-5 py-4"><div class="flex justify-end gap-3"><a href="{{ route('admin.categories.edit', $category) }}" class="font-bold text-emerald-700 hover:text-emerald-900">Edit</a><form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?')">@csrf @method('DELETE')<button class="font-bold text-rose-700 hover:text-rose-900" type="submit">Delete</button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-5 py-12 text-center text-slate-500">No categories yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-5">{{ $categories->links() }}</div>
@endsection