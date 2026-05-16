<x-app-layout>
    @section('meta_title', $event->title . ' - Events | CG Chartbusters')
    @section('meta_description', Str::limit(strip_tags($event->description), 160))

    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-8 p-4 bg-green-500/10 border border-green-500/50 rounded-2xl text-green-400 flex items-center gap-3">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            @if($event->approval_status === 'pending')
                <div class="mb-8 p-4 bg-yellow-500/10 border border-yellow-500/50 rounded-2xl text-yellow-400 flex items-center gap-3">
                    <i class="fa-solid fa-clock"></i> This event is pending approval and is only visible to you.
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Left: Banner & Description -->
                <div class="lg:col-span-2 space-y-12">
                    <!-- Banner -->
                    <div class="relative rounded-[2rem] overflow-hidden shadow-2xl border border-gray-800">
                        <img src="{{ $event->poster_url }}" alt="{{ $event->title }}" class="w-full h-auto object-cover aspect-video">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                        <div class="absolute bottom-8 left-8">
                            <span class="bg-yellow-400 text-black text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-widest mb-4 inline-block shadow-lg">
                                {{ $event->event_type }}
                            </span>
                            <h1 class="text-4xl md:text-5xl font-extrabold text-white drop-shadow-2xl">
                                {{ $event->title }}
                            </h1>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-gray-900/40 backdrop-blur-sm rounded-[2rem] p-8 border border-gray-800 shadow-xl">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                            <i class="fa-solid fa-circle-info text-yellow-400"></i> About the Event
                        </h2>
                        <div class="prose prose-invert max-w-none text-gray-300 leading-relaxed whitespace-pre-line">
                            {{ $event->description }}
                        </div>
                    </div>
                </div>

                <!-- Right: Details & CTA -->
                <div class="space-y-8">
                    <!-- Quick Info Card -->
                    <div class="bg-gray-900/80 backdrop-blur-md rounded-[2rem] p-8 border border-gray-800 shadow-2xl sticky top-8">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500 uppercase font-bold tracking-widest">Status</span>
                                @php
                                    $statusColor = match($event->status) {
                                        'Upcoming' => 'text-blue-400',
                                        'Live' => 'text-green-400',
                                        'Expired' => 'text-gray-500',
                                        default => 'text-gray-400'
                                    };
                                @endphp
                                <span class="{{ $statusColor }} font-extrabold text-lg">{{ $event->status }}</span>
                            </div>
                            <div class="flex flex-col text-right">
                                <span class="text-xs text-gray-500 uppercase font-bold tracking-widest">Entry Fee</span>
                                <span class="text-white font-extrabold text-lg">{{ $event->entry_fee }}</span>
                            </div>
                        </div>

                        <div class="space-y-6 mb-10">
                            <div class="flex items-start gap-4">
                                <div class="p-3 bg-gray-800 rounded-2xl text-yellow-400">
                                    <i class="fa-solid fa-calendar-check fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Date & Time</p>
                                    <p class="text-white font-semibold">{{ $event->start_datetime->format('l, d M Y') }}</p>
                                    <p class="text-gray-400 text-sm">{{ $event->start_datetime->format('h:i A') }} - {{ $event->end_datetime->format('h:i A') }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="p-3 bg-gray-800 rounded-2xl text-yellow-400">
                                    <i class="fa-solid fa-location-dot fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Venue</p>
                                    <p class="text-white font-semibold">{{ $event->venue }}</p>
                                    <p class="text-gray-400 text-sm">{{ $event->city }}, {{ $event->state }}</p>
                                </div>
                            </div>

                            @if($event->registration_deadline)
                            <div class="flex items-start gap-4">
                                <div class="p-3 bg-red-500/10 rounded-2xl text-red-400">
                                    <i class="fa-solid fa-hourglass-end fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-red-500/70 font-bold uppercase tracking-wider">Deadline</p>
                                    <p class="text-white font-semibold">{{ $event->registration_deadline->format('d M, Y') }}</p>
                                </div>
                            </div>
                            @endif

                            <div class="flex items-start gap-4">
                                <div class="p-3 bg-gray-800 rounded-2xl text-yellow-400">
                                    <i class="fa-solid fa-user-tie fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Organizer</p>
                                    <p class="text-white font-semibold">{{ $event->organizer_name }}</p>
                                    <p class="text-gray-400 text-sm">{{ $event->contact_email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @if($event->registration_link)
                                <a href="{{ $event->registration_link }}" target="_blank" class="w-full flex items-center justify-center gap-3 px-8 py-4 bg-yellow-400 hover:bg-yellow-300 text-black font-extrabold rounded-2xl shadow-xl shadow-yellow-400/10 transition-all transform hover:-translate-y-1">
                                    Register Now <i class="fa-solid fa-external-link text-sm"></i>
                                </a>
                            @endif
                            
                            <button onclick="window.navigator.share({ title: '{{ $event->title }}', url: window.location.href })" class="w-full flex items-center justify-center gap-3 px-8 py-4 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-2xl border border-gray-700 transition-all">
                                Share Event <i class="fa-solid fa-share-nodes"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
