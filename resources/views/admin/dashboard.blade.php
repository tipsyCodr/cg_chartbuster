@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Total Users Card -->
    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-600">Total Users</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</p>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4 text-sm text-gray-500">
            <span class="text-green-500">+{{ rand(1, 10) }}%</span> from last month
        </div>
    </div>

    <!-- Active Users Card -->
    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-600">Active Users</h3>
                <p class="text-3xl font-bold text-green-600">{{ $totalUsers }}</p>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4 text-sm text-gray-500">
            <span class="text-green-500">+{{ rand(1, 10) }}%</span> from last month
        </div>
    </div>

    <!-- Pending Reviews Card -->
    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-600">Pending Reviews</h3>
                <p class="text-3xl font-bold text-yellow-600">{{ rand(10, 50) }}</p>
            </div>
            <div class="bg-yellow-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4 text-sm text-gray-500">
            <span class="text-yellow-500">+{{ rand(1, 10) }}%</span> from last month
        </div>
    </div>

    <!-- Total Content Card -->
    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-600">Total Content</h3>
                <p class="text-3xl font-bold text-purple-600">{{ rand(100, 500) }}</p>
            </div>
            <div class="bg-purple-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4 text-sm text-gray-500">
            <span class="text-purple-500">+{{ rand(1, 10) }}%</span> from last month
        </div>
    </div>
</div>

<!-- Recent Activity Section -->
<div class="mt-8 bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-xl font-semibold mb-4 text-gray-800">Recent Activity</h3>
    <div class="divide-y divide-gray-200">
        @foreach(range(1, 5) as $index)
        <div class="py-3 flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a4 4 0 00-4-4H8a4 4 0 00-4 4v2h8v-2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700">User {{ $index }} performed an action</p>
                    <p class="text-xs text-gray-500">{{ now()->subHours($index)->diffForHumans() }}</p>
                </div>
            </div>
            <span class="text-xs text-gray-500">Details</span>
        </div>
        @endforeach
    </div>
</div>
@endsection
