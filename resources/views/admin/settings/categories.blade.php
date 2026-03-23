@extends('layouts.admin')

@section('page-title', 'Categories')

@section('content')
    <div class="mx-auto w-full">
        <div class="mb-6">
            <h2 class="text-2xl font-bold">Settings Categories</h2>
            <p class="mt-1 text-sm text-gray-500">Manage metadata used across Movies, Songs, TV Shows, and Artists.</p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <a href="{{ route('admin.genres.index') }}"
                class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm transition hover:shadow-md sm:p-5">
                <h3 class="text-lg font-semibold text-gray-800">Genres</h3>
                <p class="mt-1 text-sm text-gray-500">Create, edit, and remove genres for content filtering.</p>
                <span class="mt-3 inline-block text-sm font-medium text-indigo-600">Open Genre Management</span>
            </a>

            <a href="{{ route('admin.regions.index') }}"
                class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm transition hover:shadow-md sm:p-5">
                <h3 class="text-lg font-semibold text-gray-800">Regions</h3>
                <p class="mt-1 text-sm text-gray-500">Maintain language and regional labels for titles and songs.</p>
                <span class="mt-3 inline-block text-sm font-medium text-indigo-600">Open Region Management</span>
            </a>
        </div>
    </div>

@endsection
