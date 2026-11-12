<div>
    <label for="name" class="mb-2 block text-sm font-bold">Name</label>
    <input id="name" name="name" value="{{ old('name', $category->name ?? '') }}" required maxlength="255" class="w-full border border-slate-300 bg-white px-3 py-2.5 outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
    @error('name')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
</div>