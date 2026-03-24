@extends('layouts.admin')

@section('page-title', 'Add New Hero Banner')

@section('content')
    <div class="container px-3 py-6 mx-auto sm:px-4 sm:py-8 max-w-4xl">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold">Add New Hero Banner</h1>
            <a href="{{ route('admin.hero-banners.index') }}" class="text-accent hover:underline font-bold text-sm">
                &larr; Back to List
            </a>
        </div>

        @if ($errors->any())
            <div class="p-4 mb-6 text-red-700 bg-red-100 border border-red-400 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 sm:p-8">
            <form action="{{ route('admin.hero-banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label for="image" class="block mb-1.5 text-sm font-bold text-gray-700">Banner Image (16:9 recommended)</label>
                        <input type="file" name="image" id="image" accept="image/*" required
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-accent/10 file:text-accent hover:file:bg-accent/20 transition-all border border-gray-300 rounded-lg p-2">
                        <p class="mt-1 text-xs text-gray-500 font-medium italic">Max size: 2MB. Format: JPG, PNG, WEBP.</p>
                    </div>

                    <div>
                        <label for="link_url" class="block mb-1.5 text-sm font-bold text-gray-700">Link URL (Optional)</label>
                        <input type="url" name="link_url" id="link_url" value="{{ old('link_url') }}"
                            placeholder="https://example.com/target-page"
                            class="mt-1 block w-full rounded-lg border-gray-300 text-base p-2.5 shadow-sm focus:border-accent focus:ring focus:ring-accent/20 transition-all">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="sort_order" class="block mb-1.5 text-sm font-bold text-gray-700">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 text-base p-2.5 shadow-sm focus:border-accent focus:ring focus:ring-accent/20 transition-all">
                        </div>

                        <div class="flex items-center gap-2 pt-8">
                            <input type="checkbox" name="is_active" id="is_active" value="1" checked
                                class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent">
                            <label for="is_active" class="text-sm font-bold text-gray-700 italic">Active Status</label>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                    <a href="{{ route('admin.hero-banners.index') }}"
                        class="px-6 py-2.5 text-sm font-bold text-gray-500 uppercase rounded-lg hover:bg-gray-100 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-10 py-2.5 text-sm font-black text-white uppercase rounded-lg shadow-xl bg-accent hover:bg-accent-dark transition-all transform active:scale-95">
                        Create Banner
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
