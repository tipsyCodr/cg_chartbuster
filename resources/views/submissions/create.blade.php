<x-app-layout>
@section('meta_title', 'Add Your Content — CG Chartbusters')

<div class="py-16 bg-black min-h-screen text-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-white tracking-tight">Add Your <span class="text-yellow-400">Content</span></h1>
            <p class="mt-4 text-lg text-gray-400 max-w-2xl mx-auto">Select the type of content you want to submit to the Chhollywood ecosystem. Our team will review and publish it.</p>
        </div>

        <!-- Selection Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Movie -->
            <a href="{{ route('submit.movie.create') }}" class="group relative bg-gray-900 border border-gray-800 rounded-3xl p-8 hover:border-yellow-500/50 hover:shadow-2xl hover:shadow-yellow-500/5 transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 bg-yellow-500/10 rounded-2xl flex items-center justify-center text-yellow-500 group-hover:bg-yellow-500 group-hover:text-black transition-colors duration-300 mb-6">
                        <i class="fas fa-film text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Movie</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">Submit new feature films, indie cinema, or short films including posters, trailers, and cast details.</p>
                </div>
                <div class="mt-6 flex items-center text-yellow-500 font-bold text-sm">
                    Submit Movie <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </div>
            </a>

            <!-- Song -->
            <a href="{{ route('submit.song.create') }}" class="group relative bg-gray-900 border border-gray-800 rounded-3xl p-8 hover:border-yellow-500/50 hover:shadow-2xl hover:shadow-yellow-500/5 transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 bg-yellow-500/10 rounded-2xl flex items-center justify-center text-yellow-500 group-hover:bg-yellow-500 group-hover:text-black transition-colors duration-300 mb-6">
                        <i class="fas fa-music text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Song</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">Add tracks, albums, composition credits, singers, lyricists, and music videos.</p>
                </div>
                <div class="mt-6 flex items-center text-yellow-500 font-bold text-sm">
                    Submit Song <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </div>
            </a>

            <!-- TV Show -->
            <a href="{{ route('submit.tvshow.create') }}" class="group relative bg-gray-900 border border-gray-800 rounded-3xl p-8 hover:border-yellow-500/50 hover:shadow-2xl hover:shadow-yellow-500/5 transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 bg-yellow-500/10 rounded-2xl flex items-center justify-center text-yellow-500 group-hover:bg-yellow-500 group-hover:text-black transition-colors duration-300 mb-6">
                        <i class="fas fa-tv text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">TV Show</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">List web series, serials, and TV shows with directors, streaming info, and episodes.</p>
                </div>
                <div class="mt-6 flex items-center text-yellow-500 font-bold text-sm">
                    Submit TV Show <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </div>
            </a>

            <!-- Artist -->
            <a href="{{ route('submit.artist.create') }}" class="group relative bg-gray-900 border border-gray-800 rounded-3xl p-8 hover:border-yellow-500/50 hover:shadow-2xl hover:shadow-yellow-500/5 transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 bg-yellow-500/10 rounded-2xl flex items-center justify-center text-yellow-500 group-hover:bg-yellow-500 group-hover:text-black transition-colors duration-300 mb-6">
                        <i class="fas fa-user-friends text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Artist</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">Add actors, directors, musicians, production banners, or crew profiles to the directory.</p>
                </div>
                <div class="mt-6 flex items-center text-yellow-500 font-bold text-sm">
                    Submit Artist <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </div>
            </a>

            <!-- Event -->
            <a href="{{ route('events.submit') }}" class="group relative bg-gray-900 border border-gray-800 rounded-3xl p-8 hover:border-yellow-500/50 hover:shadow-2xl hover:shadow-yellow-500/5 transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 bg-yellow-500/10 rounded-2xl flex items-center justify-center text-yellow-500 group-hover:bg-yellow-500 group-hover:text-black transition-colors duration-300 mb-6">
                        <i class="fas fa-calendar-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Event</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">List cultural festivals, movie premieres, music shows, or other local community events.</p>
                </div>
                <div class="mt-6 flex items-center text-yellow-500 font-bold text-sm">
                    Submit Event <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </div>
            </a>
        </div>
    </div>
</div>
</x-app-layout>
