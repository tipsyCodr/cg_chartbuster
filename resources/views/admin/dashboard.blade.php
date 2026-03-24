@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-2 lg:grid-cols-4">
    <!-- Total Users Card -->
    <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow sm:p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-base font-semibold text-gray-600 sm:text-lg">Total Users</h3>
                <p class="text-2xl font-bold text-blue-600 sm:text-3xl">{{ $stats['totalUsers'] }}</p>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Movies Card -->
    <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow sm:p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-base font-semibold text-gray-600 sm:text-lg">Movies</h3>
                <p class="text-2xl font-bold text-green-600 sm:text-3xl">{{ $stats['totalMovies'] }}</p>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <i class="fas fa-film text-2xl text-green-600"></i>
            </div>
        </div>
    </div>

    <!-- Total Songs Card -->
    <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow sm:p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-base font-semibold text-gray-600 sm:text-lg">Songs</h3>
                <p class="text-2xl font-bold text-yellow-600 sm:text-3xl">{{ $stats['totalSongs'] }}</p>
            </div>
            <div class="bg-yellow-100 p-3 rounded-full">
                <i class="fas fa-music text-2xl text-yellow-600"></i>
            </div>
        </div>
    </div>

    <!-- Total Reviews Card -->
    <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow sm:p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-base font-semibold text-gray-600 sm:text-lg">Reviews</h3>
                <p class="text-2xl font-bold text-purple-600 sm:text-3xl">{{ $stats['totalReviews'] }}</p>
            </div>
            <div class="bg-purple-100 p-3 rounded-full">
                <i class="fas fa-star text-2xl text-purple-600"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 mt-8 lg:grid-cols-2">
    <!-- Quick Access -->
    <div class="bg-white p-4 rounded-lg shadow-md sm:p-6">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Quick Actions</h3>
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('admin.movies.create') }}" class="flex flex-col items-center justify-center p-4 rounded-lg bg-gray-50 hover:bg-gray-100 border border-gray-200 transition-colors">
                <i class="fas fa-plus-circle text-2xl text-blue-500 mb-2"></i>
                <span class="text-sm font-medium">Add Movie</span>
            </a>
            <a href="{{ route('admin.songs.create') }}" class="flex flex-col items-center justify-center p-4 rounded-lg bg-gray-50 hover:bg-gray-100 border border-gray-200 transition-colors">
                <i class="fas fa-plus-circle text-2xl text-yellow-500 mb-2"></i>
                <span class="text-sm font-medium">Add Song</span>
            </a>
            <a href="{{ route('admin.artists.create') }}" class="flex flex-col items-center justify-center p-4 rounded-lg bg-gray-50 hover:bg-gray-100 border border-gray-200 transition-colors">
                <i class="fas fa-plus-circle text-2xl text-green-500 mb-2"></i>
                <span class="text-sm font-medium">Add Artist</span>
            </a>
            <a href="{{ route('admin.user-management') }}" class="flex flex-col items-center justify-center p-4 rounded-lg bg-gray-50 hover:bg-gray-100 border border-gray-200 transition-colors">
                <i class="fas fa-users text-2xl text-purple-500 mb-2"></i>
                <span class="text-sm font-medium">Manage Users</span>
            </a>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="bg-white p-4 rounded-lg shadow-md sm:p-6">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Recent Reviews</h3>
        <div class="divide-y divide-gray-200">
            @forelse($stats['recentReviews'] as $review)
            <div class="py-3">
                <div class="flex items-center justify-between mb-1">
                    <span class="font-medium text-gray-800">{{ $review->user->name ?? 'User' }}</span>
                    <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-sm text-gray-600 line-clamp-1 italic">"{{ $review->review_text }}"</p>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs font-semibold px-2 py-0.5 rounded {{ $review->rating >= 7 ? 'bg-green-100 text-green-700' : ($review->rating >= 4 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                        {{ $review->rating }}/10
                    </span>
                    <span class="text-xs text-gray-400">
                        on @if($review->movie) Movie: {{ $review->movie->title }}
                           @elseif($review->song) Song: {{ $review->song->title }}
                           @elseif($review->tvshow) TV Show: {{ $review->tvshow->title }}
                           @elseif($review->artist) Artist: {{ $review->artist->name }}
                           @endif
                    </span>
                </div>
            </div>
            @empty
            <div class="py-4 text-center text-gray-500">
                No recent reviews found.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
