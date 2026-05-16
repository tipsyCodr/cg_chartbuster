<x-app-layout>
    @section('meta_title', 'Events - CG Chartbusters')
    @section('meta_description', 'Discover upcoming Chhattisgarhi cultural events, film premieres, and music festivals.')

    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
                <div>
                    <h1 class="text-4xl font-extrabold text-white tracking-tight">
                        Cultural <span class="text-yellow-400">Events</span>
                    </h1>
                    <p class="mt-2 text-lg text-gray-400">Discover and participate in the latest Chhollywood happenings.</p>
                </div>
                <a href="{{ route('events.submit') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-semibold rounded-full shadow-sm text-black bg-yellow-400 hover:bg-yellow-300 transition-all transform hover:scale-105">
                    <i class="fa-solid fa-plus mr-2"></i> Submit Event
                </a>
            </div>

            <!-- Filters & Search -->
            <div class="bg-gray-900/50 backdrop-blur-xl border border-gray-800 rounded-3xl p-6 mb-12 shadow-2xl">
                <form action="{{ route('events.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Search -->
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search events..." 
                            class="w-full bg-black border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all">
                        <i class="fa-solid fa-search absolute right-4 top-4 text-gray-500"></i>
                    </div>

                    <!-- City Filter -->
                    <select name="city" class="bg-black border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-yellow-400 transition-all">
                        <option value="">All Cities</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>

                    <!-- Type Filter -->
                    <select name="type" class="bg-black border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-yellow-400 transition-all">
                        <option value="">All Types</option>
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>

                    <!-- Status Filter -->
                    <div class="flex gap-2">
                        <select name="status" class="flex-1 bg-black border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-yellow-400 transition-all">
                            <option value="">Any Status</option>
                            <option value="Upcoming" {{ request('status') == 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="Live" {{ request('status') == 'Live' ? 'selected' : '' }}>Live</option>
                            <option value="Expired" {{ request('status') == 'Expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                        <button type="submit" class="bg-gray-800 text-white p-3 rounded-xl hover:bg-gray-700 transition-all">
                            <i class="fa-solid fa-filter"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Events Grid -->
            @if($events->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($events as $event)
                        <div class="group bg-gray-900 border border-gray-800 rounded-3xl overflow-hidden hover:border-yellow-400/50 transition-all duration-300 shadow-xl hover:shadow-yellow-400/5">
                            <!-- Poster -->
                            <div class="relative aspect-video overflow-hidden">
                                <img src="{{ $event->poster_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute top-4 left-4">
                                    @php
                                        $statusColor = match($event->status) {
                                            'Upcoming' => 'bg-blue-500',
                                            'Live' => 'bg-green-500 animate-pulse',
                                            'Expired' => 'bg-gray-600',
                                            default => 'bg-gray-500'
                                        };
                                    @endphp
                                    <span class="{{ $statusColor }} text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-lg">
                                        {{ $event->status }}
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <div class="flex items-center gap-2 text-yellow-400 text-xs font-bold uppercase tracking-widest mb-2">
                                    <i class="fa-solid fa-tag"></i> {{ $event->event_type }}
                                </div>
                                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-yellow-400 transition-colors">
                                    <a href="{{ route('events.show', $event->slug) }}">{{ $event->title }}</a>
                                </h3>
                                <div class="space-y-2 mb-6">
                                    <div class="flex items-center text-gray-400 text-sm">
                                        <i class="fa-solid fa-calendar-day w-5 text-yellow-400/70"></i>
                                        {{ $event->start_datetime->format('d M, Y | h:i A') }}
                                    </div>
                                    <div class="flex items-center text-gray-400 text-sm">
                                        <i class="fa-solid fa-location-dot w-5 text-yellow-400/70"></i>
                                        {{ $event->city }}, {{ $event->state }}
                                    </div>
                                    <div class="flex items-center text-gray-400 text-sm">
                                        <i class="fa-solid fa-user-tie w-5 text-yellow-400/70"></i>
                                        {{ $event->organizer_name }}
                                    </div>
                                </div>
                                <div class="pt-4 border-t border-gray-800 flex items-center justify-between">
                                    <span class="text-white font-bold">{{ $event->entry_fee }}</span>
                                    <a href="{{ route('events.show', $event->slug) }}" class="text-yellow-400 font-semibold flex items-center gap-2 group/btn">
                                        Details <i class="fa-solid fa-arrow-right group-hover/btn:translate-x-1 transition-transform"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $events->links() }}
                </div>
            @else
                <div class="text-center py-20 bg-gray-900/30 rounded-3xl border border-dashed border-gray-700">
                    <i class="fa-solid fa-calendar-xmark text-6xl text-gray-700 mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-400">No events found</h3>
                    <p class="text-gray-500 mt-2">Try adjusting your filters or search query.</p>
                </div>
            @endif

            <!-- Notice -->
            <div class="mt-20 p-8 bg-yellow-400/5 rounded-3xl border border-yellow-400/20 text-center">
                <p class="text-yellow-400/80 text-sm">
                    For event listing rules, refer to our <a href="{{ route('event-guidelines') }}" class="underline font-bold hover:text-yellow-400">Event Submission Guidelines</a>.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
