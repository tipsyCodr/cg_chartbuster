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
        @error('title', 'description', 'year', 'genre', 'director', 'cast', 'duration', 'poster_image', 'trailer_url')
            <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                <strong>{{ $message }}</strong>
            </div>
        @enderror

        <!-- Movie Creation Modal -->
        <div x-show="showMovieModal" x-cloak
            class="fixed inset-0 z-50 flex items-start justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none">
            <div class="relative w-full max-w-6xl mx-auto my-6">
                <div x-show="showMovieModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative flex flex-col w-full bg-white border-0 rounded-lg shadow-lg outline-none focus:outline-none z-60">

                    <!-- Modal Header -->
                    <div class="flex items-start justify-between p-5 border-b border-solid rounded-t border-blueGray-200">
                        <h3 class="text-2xl font-semibold">Add New Song</h3>
                        <button @click="showMovieModal = false"
                            class="float-right p-1 ml-auto text-3xl font-semibold leading-none text-black border-0  focus:outline-none">
                            <span class="block w-6 h-6 text-2xl text-black">×</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form action="{{ route('admin.songs.store') }}" method="POST" enctype="multipart/form-data"
                        class="relative flex-auto p-6">
                        @csrf
                        <div class="">
                            <div class="mb-4 ">
                            <div class="mb-4">
                                <label for="show_on_banner" class="block my-1 text-sm font-medium text-gray-700">Show on banner</label>
                                <select name="show_on_banner" id="show_on_banner" class="mt-1 block w-full rounded-md  border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="1" >Yes</option>
                                    <option value="0" >No</option>
                                </select>
                            </div>
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
                                <select name="genre" id="genre" class="w-full p-2 my-2 border border-gray-300 rounded">
                                    <option value="">Select</option>
                                    @foreach ($genres as $genre)
                                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                    @endforeach
                                </select>
                                @error('genre')
                                    @foreach ($errors->get('genre') as $message)
                                        <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}
                                        </div>
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

                         


                            <div x-data="{ 
                                artistEntries: [{ artist: '', role: '' }],
                                artists: [],
                                categories: [],
                                fetchData() {
                                    fetch('{{ route('admin.artists.list') }}')
                                        .then(response => response.json())
                                        .then(data => {
                                            this.artists = data.artists;
                                            this.categories = data.categories;
                                        })
                                },
                                addArtistEntry() {
                                    this.artistEntries.push({ artist: '', role: '' });
                                },
                                removeArtistEntry(index) {
                                    this.artistEntries.splice(index, 1);
                                }
                            }" 
                            x-init="fetchData()">
                                <label class="block my-1 text-sm font-medium text-gray-700">Artists</label>
                                
                                <template x-for="(entry, index) in artistEntries" :key="index">
                                    <div class="flex gap-2 mt-2">
                                        <select x-model="entry.artist" 
                                                :name="'artists[' + index + '][artist_id]'" 
                                                class="w-2/3 p-2 border border-gray-300 rounded">
                                            <option value="">Select Artist</option>
                                            <template x-for="artist in artists" :key="artist.id">
                                                <option :value="artist.id" x-text="artist.name"></option>
                                            </template>
                                        </select>
                                        
                                        <select x-model="entry.role" 
                                                :name="'artists[' + index + '][role]'" 
                                                class="w-1/3 p-2 border border-gray-300 rounded">
                                            <option value="">Select Role</option>
                                            <template x-for="category in categories" :key="category.id">
                                                <option :value="category.id" x-text="category.name"></option>
                                            </template>
                                        </select>
                                        
                                        <button type="button" 
                                                @click="removeArtistEntry(index)"
                                                class="px-2 py-1 text-white bg-red-500 rounded hover:bg-red-600">
                                            Remove
                                        </button>
                                    </div>
                                </template>
                            
                                <button type="button" 
                                        @click="addArtistEntry()"
                                        class="px-4 py-2 mt-2 text-white bg-green-500 rounded hover:bg-green-600">
                                    Add Another Artist
                                </button>
                            </div>
                            @error('artists')
                                <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror






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

                            <div x-data="{ 
                                regions: [], 
                                selectedRegion: '', 
                                fetchRegions() {
                                    fetch('{{ route('regions') }}')
                                        .then(response => response.json())
                                        .then(data => {
                                            this.regions = data; // Update the Alpine.js reactive variable
                                        })
                                        .catch(error => console.error('Error fetching regions:', error));
                                }, 
                                addRegion() {
                                    const newRegion = document.getElementById('region_other').value;
                                    if (newRegion.trim() === '') return;
                        
                                    fetch(`/region/add/${newRegion}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            console.log('Region added:', data);
                                            this.fetchRegions(); // Refresh the regions after adding a new region
                                        })
                                        .catch(error => console.error('Error adding language:', error));
                        
                                    document.getElementById('region_other').value = ''; // Clear the input field
                                    this.selectedRegion = ''; // Reset the selected region
                                    $refs.regionInput.classList.add('hidden'); // Hide the input field
                                } 
                            }" 
                            x-init="fetchRegions()"
                        >
                            <label for="region" class="block my-1 text-sm font-medium text-gray-700">Language</label>
                            <select name="region" id="region" 
                                x-model="selectedRegion" 
                                class="w-full p-2 my-2 border border-gray-300 rounded"
                                @change="selectedRegion == 'other' ? $refs.regionInput.classList.remove('hidden') : $refs.regionInput.classList.add('hidden')">
                                <option value="">Select</option>    
                                <template x-for="region in regions" :key="region.id">
                                    <option :value="region.name" x-text="region.name.toUpperCase()"></option>
                                </template>
                                <option value="other">Other</option>    
                            </select>
                            <div class="hidden" id="regionInput" x-ref="regionInput">
                                <input type="text" id="region_other" name="region_other" placeholder="Enter Region" class="w-full p-2 my-2 border border-gray-300 rounded">
                                <button type="button" @click="addRegion" class="px-4 py-2 my-2 bg-blue-500 text-white rounded">Add</button>
                            </div>
                        </div>

                            <div>
                                <label for="cbfc"
                                    class="block my-1 text-sm font-medium text-gray-700">CBFC</label>
                                <select name="cbfc" id="cbfc" class="w-full p-2 my-2 border border-gray-300 rounded">
                                    <option value="U">U</option>
                                    <option value="UA 7+">UA 7+</option>
                                    <option value="UA 13+">UA 13+</option>
                                    <option value="UA 16+">UA 16+</option>
                                    <option value="A">A (18+)</option>
                                    <option value="S">S</option>
                                    <option value="NA">NA</option>
                                </select>
                            </div>

                            <div>
                                <label for="cg_chartbusters_ratings" class="block my-1 text-sm font-medium text-gray-700">CG Chartbusters Ratings</label>
                                <x-star-rating id="rating" class="block mt-1 w-full" name="cg_chartbusters_ratings" required></x-star-rating>
                            </div>

                            <div>
                                <label for="imdb_ratings" class="block my-1 text-sm font-medium text-gray-700">IMDB Ratings</label>
                                    <x-star-rating id="rating" class="block mt-1 w-full" name="imdb_ratings" required></x-star-rating>
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
                                <label for="singer_male" class="block my-1 text-sm font-medium text-gray-700">Singer
                                    Male</label>
                                <select name="singer_male" id="singer_male" class="w-full p-2 my-2 border border-gray-300 rounded">
                                    <option value="">Select Singer Male</option>
                                    @foreach ($singer_male as $singer)
                                        <option value="{{ $singer->id }}">{{ $singer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="singer_female" class="block my-1 text-sm font-medium text-gray-700">Singer
                                    Female</label>
                                <select name="singer_female" id="singer_female" class="w-full p-2 my-2 border border-gray-300 rounded">
                                    <option value="">Select Singer Female</option>
                                    @foreach ($singer_female as $singer)
                                        <option value="{{ $singer->id }}">{{ $singer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="lyrics" class="block my-1 text-sm font-medium text-gray-700">Lyrics</label>
                                <textarea name="lyrics" id="lyrics" rows="3"
                                        class="w-full p-2 my-2 border border-gray-300 rounded"></textarea>
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
                                <label for="poster_logo"
                                    class="block my-1 text-sm font-medium text-gray-700">Poster Logo</label>
                                <input type="text" name="poster_logo" id="poster_logo" 
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>
                            <div>
                                <label for="production_banner"
                                    class="block my-1 text-sm font-medium text-gray-700">Production Banner</label>
                                <input type="text" name="production_banner" id="production_banner"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>
                                                   

                            <div>
                                <label for="others" class="block my-1 text-sm font-medium text-gray-700">Others</label>
                                <input type="text" name="others" id="others"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>
{{-- 
                            <div>
                                <label for="content_description" class="block my-1 text-sm font-medium text-gray-700">Content Description</label>
                                <textarea name="content_description" id="content_description" rows="3"
                                    class="w-full p-2 my-2 border border-gray-300 rounded"></textarea>
                            </div> --}}

                            <div>
                                <label for="trailer_url"
                                    class="block my-1 text-sm font-medium text-gray-700">Trailer URL</label>
                                <textarea name="trailer_url" id="trailer_url" rows="3" class="w-full p-2 my-2 border border-gray-300 rounded"></textarea>
                                @error('trailer_url')
                                    @foreach ($errors->get('trailer_url') as $message)
                                        <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">
                                            {{ $message }}</div>
                                    @endforeach
                                @enderror
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
                                Save 
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="fixed inset-0 bg-black opacity-25 -z-10 backdrop-blur-lg" @click="showMovieModal = false"></div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow-md">
            <livewire:dynamic-search 
                model="Song" 
                :columns="['poster_image','title','release_date']" 
            />
 
            
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
