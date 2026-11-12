@extends('admin.layout')

@section('title', 'Add product')
@section('page-title', 'Add product')

@section('content')
    @if ($categories->isEmpty())
        <div class="border-l-4 border-amber-500 bg-amber-50 px-4 py-3 text-sm text-amber-900">Create a category before adding products. <a href="{{ route('admin.categories.create') }}" class="font-bold underline">Add category</a></div>
    @endif
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="max-w-3xl border border-slate-200 bg-white p-5 sm:p-7">
        @csrf
        @include('admin.products._form')
        <div class="mt-7 flex gap-3"><button type="submit" @disabled($categories->isEmpty()) class="bg-slate-950 px-5 py-3 text-sm font-bold text-white hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50">Create product</button><a href="{{ route('admin.products.index') }}" class="px-4 py-3 text-sm font-bold text-slate-600 hover:text-slate-950">Cancel</a></div>
    </form>
@endsection