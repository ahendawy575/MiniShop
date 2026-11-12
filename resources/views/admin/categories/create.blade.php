@extends('admin.layout')

@section('title', 'Add category')
@section('page-title', 'Add category')

@section('content')
    <form action="{{ route('admin.categories.store') }}" method="POST" class="max-w-2xl border border-slate-200 bg-white p-5 sm:p-7">
        @csrf
        @include('admin.categories._form')
        <div class="mt-7 flex gap-3"><button type="submit" class="bg-slate-950 px-5 py-3 text-sm font-bold text-white hover:bg-slate-800">Create category</button><a href="{{ route('admin.categories.index') }}" class="px-4 py-3 text-sm font-bold text-slate-600 hover:text-slate-950">Cancel</a></div>
    </form>
@endsection