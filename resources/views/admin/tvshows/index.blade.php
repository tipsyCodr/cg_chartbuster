@extends('layouts.admin')

@section('content')
    <div x-data="{ showMovieModal: false }" class="container px-3 py-6 mx-auto sm:px-4 sm:py-8">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-2xl font-bold">TV Show Management</h1>
            <button @click="showMovieModal = true"
                class="px-4 py-2 text-white transition rounded bg-accent hover:bg-accent-dark">
                Add New TV Show
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

        <!-- TV Show Creation Modal -->
        <div x-show="showMovieModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-0 sm:p-4 outline-none focus:outline-none">
            <div class="relative w-full h-full sm:h-auto sm:max-w-6xl mx-auto flex flex-col sm:my-6">
                <div x-show="showMovieModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative flex flex-col w-full h-full sm:h-auto max-h-screen bg-white sm:rounded-2xl shadow-2xl outline-none focus:outline-none z-60 overflow-hidden">

                    <!-- Modal Header -->
                    <div class="flex items-start justify-between p-5 border-b border-solid rounded-t border-blueGray-200">
                        <h3 class="text-2xl font-semibold">Add New TV Show</h3>
                        <button @click="showMovieModal = false"
                            class="float-right p-1 ml-auto text-3xl font-semibold leading-none text-black bg-transparent border-0 outline-none focus:outline-none">
                            <span class="block w-6 h-6 text-2xl text-black bg-transparent">×</span>
                        </button>
                    </div>
                    <!-- Modal Body -->
                    <form action="{{ route('admin.tvshows.store') }}" method="POST" enctype="multipart/form-data"
                        class="relative flex-auto p-5 sm:p-8 overflow-y-auto custom-scrollbar">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label for="show_on_banner" class="block mb-1.5 text-sm font-bold text-gray-700">Show on banner</label>
                                    <select name="show_on_banner" id="show_on_banner" class="mt-1 block w-full rounded-lg border-gray-300 text-base p-2.5 shadow-sm focus:border-accent focus:ring focus:ring-accent/20 transition-all">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="banner_label" class="block mb-1.5 text-sm font-bold text-gray-700">Banner Label</label>
                                    <select name="banner_label" id="banner_label" class="mt-1 block w-full rounded-lg border-gray-300 text-base p-2.5 shadow-sm focus:border-accent focus:ring focus:ring-accent/20 transition-all">
                                        <option value="">None</option>
                                        <option value="🎬 Watch on Official YouTube Channel">🎬 Watch on Official YouTube Channel</option>
                                        <option value="🎥 Watch in Theaters">🎥 Watch in Theaters</option>
                                        <option value="🔜 Upcoming Release">🔜 Upcoming Release</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="banner_link" class="block mb-1.5 text-sm font-bold text-gray-700">Banner Link (URL)</label>
                                    <input type="url" name="banner_link" id="banner_link"
                                        class="mt-1 block w-full rounded-lg border-gray-300 text-base p-2.5 shadow-sm focus:border-accent focus:ring focus:ring-accent/20 transition-all"
                                        placeholder="https://...">
                                </div>
                                
                                <div>
                                    <label for="title" class="block mb-1.5 text-sm font-bold text-gray-700">TV Show Title</label>
                                    <input type="text" name="title" id="title" required
                                        class="mt-1 block w-full rounded-lg {{ $errors->has('title') ? 'border-red-500' : 'border-gray-300' }} text-base p-2.5 shadow-sm focus:border-accent focus:ring focus:ring-accent/20 transition-all">
                                    @error('title')
                                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="description" class="block mb-1.5 text-sm font-bold text-gray-700">Description (English)</label>
                                    <textarea name="description" id="description" rows="4"
                                        class="mt-1 block w-full rounded-lg border-gray-300 text-base p-2.5 shadow-sm focus:border-accent focus:ring focus:ring-accent/20 transition-all"></textarea>
                                </div>

                                <div>
                                    <label for="content_description" class="block mb-1.5 text-sm font-bold text-gray-700">Plot (Hindi)</label>
                                    <textarea name="content_description" id="content_description" rows="4"
                                        class="mt-1 block w-full rounded-lg border-gray-300 text-base p-2.5 shadow-sm focus:border-accent focus:ring focus:ring-accent/20 transition-all"></textarea>
                                </div>

                                <div>
                                    <label for="release_date" class="block mb-1.5 text-sm font-bold text-gray-700">Release Date</label>
                                    <div class="flex flex-col gap-3">
                                        <input type="date" name="release_date" id="release_date"
                                            class="w-full p-2.5 border border-gray-300 rounded-lg text-base shadow-sm focus:border-accent focus:ring focus:ring-accent/20 transition-all">
                                        <div class="flex items-center gap-2">
                                            <input type="hidden" name="is_release_year_only" value="0">
                                            <input type="checkbox" name="is_release_year_only" id="is_release_year_only" value="1" {{ old('is_release_year_only') ? 'checked' : '' }} 
                                                class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent">
                                            <label for="is_release_year_only" class="text-sm font-medium text-gray-600">Show Year Only</label>
                                        </div>
                                    </div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('is_release_year_only');
        const dateInput = document.getElementById('release_date') || document.getElementById('birth_date');
        function toggleDateInput() {
            if (checkbox.checked) {
                if (dateInput.value && dateInput.value.includes('-')) {
                    dateInput.dataset.fullDate = dateInput.value;
                    dateInput.value = dateInput.value.split('-')[0];
                }
                dateInput.type = 'number';
                dateInput.min = '1900';
                dateInput.max = '2100';
                dateInput.placeholder = 'YYYY';
            } else {
                dateInput.type = 'date';
                dateInput.removeAttribute('min');
                dateInput.removeAttribute('max');
                dateInput.removeAttribute('placeholder');
                if (dateInput.dataset.fullDate && !dateInput.value.includes('-')) {
                    dateInput.value = dateInput.dataset.fullDate;
                } else if (dateInput.value && !dateInput.value.includes('-') && dateInput.value.length === 4) {
                    dateInput.value = dateInput.value + '-01-01';
                }
            }
        }
        if (checkbox && dateInput) {
            checkbox.addEventListener('change', toggleDateInput);
            toggleDateInput();
            const form = dateInput.closest('form');
            if (form) {
                form.addEventListener('submit', function() {
                    if (checkbox.checked && dateInput.value && !dateInput.value.includes('-')) {
                        dateInput.type = 'text';
                        dateInput.value = dateInput.value + '-01-01';
                    }
                });
            }
        }
    });
</script>
                                    @error('release_date')
                                        @foreach ($errors->get('release_date') as $message)
                                            <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}
                                            </div>
                                        @endforeach
                                    @enderror
                                </div>

                                <div>
                                    <label class="block mb-1.5 text-sm font-bold text-gray-700">Genres</label>
                                    <x-searchable-multiselect 
                                        :options="$genres" 
                                        :selected="old('genre_ids', [])" 
                                        name="genre_ids" 
                                        placeholder="Search & Select Genres" 
                                    />
                                    @error('genre_ids')
                                        @foreach ($errors->get('genre_ids') as $message)
                                            <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}
                                            </div>
                                        @endforeach
                                    @enderror
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
                                    <label class="block mb-1.5 text-sm font-bold text-gray-700">Artists & Roles</label>
                                    
                                    <div class="space-y-3">
                                        <template x-for="(entry, index) in artistEntries" :key="index">
                                            <div class="p-4 border border-gray-100 rounded-xl bg-gray-50/50 space-y-4">
                                                <div class="grid grid-cols-1 gap-4">
                                                    <select x-model="entry.artist" 
                                                            :name="'artists[' + index + '][artist_id]'" 
                                                            class="w-full p-2.5 border border-gray-300 rounded-lg text-base shadow-sm">
                                                        <option value="">Select Artist</option>
                                                        <template x-for="artist in artists" :key="artist.id">
                                                            <option :value="artist.id" x-text="artist.name"></option>
                                                        </template>
                                                    </select>
                                                    
                                                    <select x-model="entry.role" 
                                                            :name="'artists[' + index + '][role]'" 
                                                            class="w-full p-2.5 border border-gray-300 rounded-lg text-base shadow-sm">
                                                        <option value="">Select Role</option>
                                                        <template x-for="category in categories" :key="category.id">
                                                            <option :value="category.id" x-text="category.name"></option>
                                                        </template>
                                                    </select>
                                                </div>
                                                
                                                <button type="button" 
                                                        @click="removeArtistEntry(index)"
                                                        class="w-full px-4 py-2.5 text-sm font-bold text-red-500 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                                    Remove Artist
                                                </button>
                                            </div>
                                        </template>
                                    
                                        <button type="button" 
                                                @click="addArtistEntry()"
                                                class="w-full px-4 py-3 text-sm font-bold text-accent bg-accent/5 border border-dashed border-accent/20 rounded-xl hover:bg-accent/10 transition-colors">
                                            + Add Another Artist
                                        </button>
                                    </div>
                                </div>
                                @error('artists')
                                    <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="space-y-4">
                                <div x-data="{ 
                                    regions: [], 
                                    selectedRegion: '', 
                                    fetchRegions() {
                                        fetch('{{ route('regions') }}')
                                            .then(response => response.json())
                                            .then(data => {
                                                this.regions = data;
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
                                                this.fetchRegions();
                                                this.selectedRegion = data.region.id;
                                            })
                                            .catch(error => console.error('Error adding language:', error));
                            
                                        document.getElementById('region_other').value = '';
                                        $refs.regionInput.classList.add('hidden');
                                    } 
                                }" 
                                x-init="fetchRegions()">
                                    <label for="region" class="block mb-1.5 text-sm font-bold text-gray-700">Language</label>
                                    <select name="region_id" id="region" 
                                        x-model="selectedRegion" 
                                        class="w-full p-2.5 border border-gray-300 rounded-lg text-base shadow-sm"
                                        @change="selectedRegion == 'other' ? $refs.regionInput.classList.remove('hidden') : $refs.regionInput.classList.add('hidden')">
                                        <option value="">Select Language</option>    
                                        <template x-for="region in regions" :key="region.id">
                                            <option :value="region.id" x-text="region.name" class="capitalize"></option>
                                        </template>
                                        <option value="other">Other...</option>    
                                    </select>   
                                    <div class="hidden mt-3 space-y-2" id="regionInput" x-ref="regionInput">
                                        <input type="text" id="region_other" name="region_other" placeholder="Enter Language" class="w-full p-2.5 border border-gray-300 rounded-lg text-base shadow-sm">
                                        <button type="button" @click="addRegion" class="w-full px-4 py-2.5 bg-accent text-white font-bold rounded-lg shadow-md">Add Language</button>
                                    </div>
                                </div>

                                <div>
                                    <label for="cbfc" class="block mb-1.5 text-sm font-bold text-gray-700">CBFC Rating</label>
                                    <select name="cbfc" id="cbfc" class="w-full p-2.5 border border-gray-300 rounded-lg text-base shadow-sm">
                                        <option value="U">U</option>
                                        <option value="UA 7+">UA 7+</option>
                                        <option value="UA 13+">UA 13+</option>
                                        <option value="UA 16+">UA 16+</option>
                                        <option value="A">A (18+)</option>
                                        <option value="S">S</option>
                                        <option value="NA">NA</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="cg_chartbusters_ratings" class="block mb-1.5 text-sm font-bold text-gray-700">CG Chartbusters Rating</label>
                                    <x-star-rating id="cg_chartbusters_ratings" class="block w-full" name="cg_chartbusters_ratings" required></x-star-rating>
                                </div>

                                <div>
                                    <label for="trailer_url" class="block mb-1.5 text-sm font-bold text-gray-700">Trailer URL</label>
                                    <input type="text" name="trailer_url" id="trailer_url"
                                        class="w-full p-2.5 border border-gray-300 rounded-lg text-base shadow-sm focus:border-accent" placeholder="https://youtube.com/...">
                                    @error('trailer_url')
                                        @foreach ($errors->get('trailer_url') as $message)
                                            <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">
                                                {{ $message }}</div>
                                        @endforeach
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label for="poster_image" class="block mb-1.5 text-sm font-bold text-gray-700">Poster Image (Portrait)</label>
                                        <input type="file" name="poster_image" id="poster_image" accept="image/*"
                                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-accent/10 file:text-accent hover:file:bg-accent/20 transition-all">
                                        @error('poster_image')
                                            @foreach ($errors->get('poster_image') as $message)
                                                <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">
                                                    {{ $message }}</div>
                                            @endforeach
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="poster_image_landscape" class="block mb-1.5 text-sm font-bold text-gray-700">Poster Image (Landscape)</label>
                                        <input type="file" name="poster_image_landscape" id="poster_image_landscape" accept="image/*"
                                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-accent/10 file:text-accent hover:file:bg-accent/20 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                            <button type="button" @click="showMovieModal = false"
                                class="w-full sm:w-auto px-6 py-2.5 text-sm font-bold text-gray-500 uppercase rounded-lg hover:bg-gray-100 transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                class="w-full sm:w-auto px-10 py-2.5 text-sm font-black text-white uppercase rounded-lg shadow-xl bg-accent hover:bg-accent-dark transition-all transform active:scale-95">
                                Save TV Show
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="fixed inset-0 bg-black opacity-25 -z-10 backdrop-blur-lg" @click="showMovieModal = false"></div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow-md">
            <livewire:dynamic-search model="TvShow"  :columns="['poster_image','title','release_date']"/> 
            
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

