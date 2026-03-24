@extends('layouts.admin')

@section('page-title', 'Hero Banners')

@section('content')
    <div class="container px-3 py-6 mx-auto sm:px-4 sm:py-8">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-2xl font-bold text-gray-800">Hero Banners</h1>
            <a href="{{ route('admin.hero-banners.create') }}"
                class="px-4 py-2 text-white transition rounded bg-accent hover:bg-accent-dark text-center">
                Add New Hero Banner
            </a>
        </div>

        @if (session('success'))
            <div class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden bg-white rounded-lg shadow-md border border-gray-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-widest">Image</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-widest">Link URL</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-widest text-center">Order</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 italic">
                    @forelse ($banners as $banner)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <img src="{{ asset('storage/' . $banner->image_path) }}" 
                                     class="w-32 h-16 object-cover rounded shadow-sm border border-gray-200" alt="Banner">
                            </td>
                            <td class="px-6 py-4">
                                @if($banner->link_url)
                                    <a href="{{ $banner->link_url }}" target="_blank" class="text-blue-500 hover:underline truncate inline-block max-w-[200px]">
                                        {{ $banner->link_url }}
                                    </a>
                                @else
                                    <span class="text-gray-400">None</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center font-bold">{{ $banner->sort_order }}</td>
                            <td class="px-6 py-4 text-center">
                                @if ($banner->is_active)
                                    <span class="px-2 py-1 text-xs font-bold text-green-700 bg-green-100 rounded-full">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-bold text-red-700 bg-red-100 rounded-full">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.hero-banners.edit', $banner) }}"
                                        class="px-3 py-1 text-xs font-bold text-white bg-blue-500 rounded hover:bg-blue-600 transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.hero-banners.destroy', $banner) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this banner?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 text-xs font-bold text-white bg-red-500 rounded hover:bg-red-600 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">
                                No Hero Banners found. The default static Hero Section will be shown.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
