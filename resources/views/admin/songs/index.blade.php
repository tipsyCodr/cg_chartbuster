@extends('layouts.admin')

@section('content')
    <div x-data="{ showMovieModal: false }" class="container px-4 py-8 mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Songs Management</h1>
            <button @click="showMovieModal = true"
                class="px-4 py-2 text-white transition rounded bg-accent hover:bg-accent-dark">
                Add New Song
            </button>
        </div>

        @if (session('success'))
            <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-red-500">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @error('title', 'description', 'year', 'genre', 'director', 'cast', 'duration', 'poster', 'trailer')
            <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                <strong>{{ $message }}</strong>
            </div>
        @enderror

        <!-- Movie Creation Modal -->
        <div x-show="showMovieModal" x-cloak
            class="fixed inset-0 z-50 flex items-start justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none">
            <div class="relative w-auto max-w-3xl mx-auto my-6">
                <div x-show="showMovieModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative flex flex-col w-full bg-white border-0 rounded-lg shadow-lg outline-none focus:outline-none z-60">

                    <!-- Modal Header -->
                    <div class="flex items-start justify-between p-5 border-b border-solid rounded-t border-blueGray-200">
                        <h3 class="text-2xl font-semibold">Add New Song</h3>
                        <button @click="showMovieModal = false"
                            class="float-right p-1 ml-auto text-3xl font-semibold leading-none text-black bg-transparent border-0 outline-none opacity-5 focus:outline-none">
                            <span class="block w-6 h-6 text-2xl text-black bg-transparent opacity-5">×</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form action="{{ route('admin.songs.store') }}" method="POST" enctype="multipart/form-data"
                        class="relative flex-auto p-6">
                        @csrf
                        <div class="">
                            <div class="mb-4 ">

                            <div>
                                <label for="title" class="block my-1 text-sm font-medium text-gray-700">Song Title</label>
                                <input type="text" name="title" id="title" required
                                    class="mt-1 block w-full rounded-md @error('title') is-invalid @enderror border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('title')
                                    @foreach ($errors->get('title') as $message)
                                        <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                                    @endforeach
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block my-1 text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="3"
                                    class="mt-1 block w-full @error('description') is-invalid @enderror rounded-md border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                                @error('description')
                                    @foreach ($errors->get('description') as $message)
                                        <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                                    @endforeach
                                @enderror
                            </div>

                            <div>
                                <label for="release_date" class="block my-1 text-sm font-medium text-gray-700">Release Date</label>
                                <input type="date" name="release_date" id="release_date"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                                @error('release_date')
                                    @foreach ($errors->get('release_date') as $message)
                                        <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                                    @endforeach
                                @enderror
                            </div>

                            <div>
                                <label for="genre" class="block my-1 text-sm font-medium text-gray-700">Genre</label>
                                <input type="text" name="genre" id="genre"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                                @error('genre')
                                    @foreach ($errors->get('genre') as $message)
                                        <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                                    @endforeach
                                @enderror
                            </div>

                            <div x-data="{ hours: 0, minutes: 0 }">
                                <input type="hidden" name="duration" id="duration" 
                                    :value="`${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`" 
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                                
                                <label class="block my-1 text-sm font-medium text-gray-700">Duration</label>
                                <div class="flex items-center space-x-2">
                                    <div>
                                        <label for="movie-duration-hour" class="block my-1 text-sm font-medium text-gray-700">Hour</label>
                                        <input type="number" placeholder="HH" id="movie-duration-hour" name="movie_duration_hour" 
                                            x-model.number="hours" min="0" step="1" class="w-20 p-2 my-2 border border-gray-300 rounded">
                                    </div>
                                    <span class="pt-5 mx-2">:</span>
                                    <div>
                                        <label for="movie-duration-minute" class="block my-1 text-sm font-medium text-gray-700">Minute</label>
                                        <input type="number" placeholder="MM" id="movie-duration-minute" name="movie_duration_minute" 
                                            x-model.number="minutes" min="0" max="59" step="1" class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="director" class="block my-1 text-sm font-medium text-gray-700">Director</label>
                                <input type="text" name="director" id="director"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                                @error('director')
                                    @foreach ($errors->get('director') as $message)
                                        <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                                    @endforeach
                                @enderror
                            </div>

                            <div>
                                <label for="region" class="block my-1 text-sm font-medium text-gray-700">Region</label>
                                <input type="text" name="region" id="region"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>

                            <div>
                                <label for="cg_chartbusters_ratings" class="block my-1 text-sm font-medium text-gray-700">CG Chartbusters Ratings</label>
                                <input type="number" name="cg_chartbusters_ratings" id="cg_chartbusters_ratings"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>

                            <div>
                                <label for="imdb_ratings" class="block my-1 text-sm font-medium text-gray-700">IMDB Ratings</label>
                                <input type="number" name="imdb_ratings" id="imdb_ratings"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>

                            <div>
                                <label for="support_artists" class="block my-1 text-sm font-medium text-gray-700">Support Artists</label>
                                <input type="text" name="support_artists" id="support_artists"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>

                            <div>
                                <label for="producer" class="block my-1 text-sm font-medium text-gray-700">Producer</label>
                                <input type="text" name="producer" id="producer"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>

                            <div>
                                <label for="singer_male" class="block my-1 text-sm font-medium text-gray-700">Singer Male</label>
                                <input type="text" name="singer_male" id="singer_male"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>

                            <div>
                                <label for="singer_female" class="block my-1 text-sm font-medium text-gray-700">Singer Female</label>
                                <input type="text" name="singer_female" id="singer_female"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>

                            <div>
                                <label for="lyrics" class="block my-1 text-sm font-medium text-gray-700">Lyrics</label>
                                <input type="text" name="lyrics" id="lyrics"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>

                            <div>
                                <label for="composition" class="block my-1 text-sm font-medium text-gray-700">Composition</label>
                                <input type="text" name="composition" id="composition"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>

                            <div>
                                <label for="mix_master" class="block my-1 text-sm font-medium text-gray-700">Mix Master</label>
                                <input type="text" name="mix_master" id="mix_master"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>

                            <div>
                                <label for="music" class="block my-1 text-sm font-medium text-gray-700">Music</label>
                                <input type="text" name="music" id="music"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>

                            <div>
                                <label for="recordists" class="block my-1 text-sm font-medium text-gray-700">Recordists</label>
                                <input type="text" name="recordists" id="recordists"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>

                            <div>
                                <label for="audio_studio" class="block my-1 text-sm font-medium text-gray-700">Audio Studio</label>
                                <input type="text" name="audio_studio" id="audio_studio"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>

                            <div>
                                <label for="editor" class="block my-1 text-sm font-medium text-gray-700">Editor</label>
                                <input type="text" name="editor" id="editor"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>

                     
                         
                            <div>
                                <label for="make_up" class="block my-1 text-sm font-medium text-gray-700">Make Up</label>
                                <input type="text" name="make_up" id="make_up"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>
                            <div>
                                <label for="artist" class="block my-1 text-sm font-medium text-gray-700">Artists</label>
                                <input type="text" name="artist" id="artist"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>

                        

                            <div>
                                <label for="others" class="block my-1 text-sm font-medium text-gray-700">Others</label>
                                <input type="text" name="others" id="others"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>

                            <div>
                                <label for="content_description" class="block my-1 text-sm font-medium text-gray-700">Content Description</label>
                                <textarea name="content_description" id="content_description" rows="3"
                                    class="w-full p-2 my-2 border border-gray-300 rounded"></textarea>
                            </div>

                            
                            {{-- <div>
                                <label for="hyperlinks_links" class="block my-1 text-sm font-medium text-gray-700">Hyperlinks Links</label>
                                <input type="text" name="hyperlinks_links" id="hyperlinks_links"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div> --}}

                            <div>
                                <label for="poster_image" class="block my-1 text-sm font-medium text-gray-700">Poster Image</label>
                                <input type="file" name="poster_image" id="poster_image" accept="image/*"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                                @error('poster_image')
                                    @foreach ($errors->get('poster_image') as $message)
                                        <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                                    @endforeach
                                @enderror
                            </div>

                            {{-- <div>
                                <label for="poster_image_landscape" class="block my-1 text-sm font-medium text-gray-700">Poster Image Landscape</label>
                                <input type="file" name="poster_image_landscape" id="poster_image_landscape"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div> --}}
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center justify-end p-6 border-t border-solid rounded-b border-blueGray-200">
                            <button type="button" @click="showMovieModal = false"
                                class="px-6 py-2 mr-4 text-sm font-bold text-red-500 uppercase transition-all duration-150 ease-linear bg-transparent rounded outline-none hover:bg-red-100 focus:outline-none">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-6 py-2 text-sm font-bold text-white uppercase rounded shadow bg-accent hover:bg-accent-dark focus:outline-none focus:ring">
                                Save Movie
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="fixed inset-0 bg-black opacity-25 -z-10 backdrop-blur-lg"></div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow-md">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th
                            class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                            Poster
                        </th>
                        <th
                            class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                            Title
                        </th>
                        <th
                            class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                            Release Year
                        </th>
                        <th
                            class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($songs as $song)
                        <tr>
                            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                <img src="{{ Storage::url($song->poster_image) }}" alt="{{ $song->title }}"
                                    class="object-cover w-16 h-24 rounded">
                            </td>
                            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                {{ $song->title }}
                            </td>
                            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                {{ $song->release_date }}
                            </td>
                            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.songs.edit', $song) }}"
                                        class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <form action="{{ route('admin.songs.destroy', $song) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this movie?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-5 text-center text-gray-500">
                                No Songs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="flex justify-center p-2 space-x-4">
                {{ $songs->links() }}
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush
