@extends('layouts.admin')

@section('content')
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Movie') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="mx-auto max-w-7xl px-3 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Edit TV Show
                    </h3>
                </div>
                <div class="px-4 py-5 overflow-hidden bg-white shadow sm:rounded-md mt-50 sm:p-6">
                    <form method="POST" action="{{ route('admin.tvshows.update', ['tvshow' => $tvshows->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="">
                            <div class="mb-4 ">

                                <div class="mb-4">
                                    <label for="show_on_banner" class="block my-1 text-sm font-medium text-gray-700">Show on banner</label>
                                    <select name="show_on_banner" id="show_on_banner" class="mt-1 block w-full rounded-md  border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="1" {{ $tvshows->show_on_banner ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ !$tvshows->show_on_banner ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="banner_label" class="block my-1 text-sm font-medium text-gray-700">Banner Label</label>
                                    <select name="banner_label" id="banner_label" class="mt-1 block w-full rounded-md border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="" {{ empty($tvshows->banner_label) ? 'selected' : '' }}>None</option>
                                        <option value="🎬 Watch on Official YouTube Channel" {{ $tvshows->banner_label == '🎬 Watch on Official YouTube Channel' ? 'selected' : '' }}>🎬 Watch on Official YouTube Channel</option>
                                        <option value="🎥 Watch in Theaters" {{ $tvshows->banner_label == '🎥 Watch in Theaters' ? 'selected' : '' }}>🎥 Watch in Theaters</option>
                                        <option value="🔜 Upcoming Release" {{ $tvshows->banner_label == '🔜 Upcoming Release' ? 'selected' : '' }}>🔜 Upcoming Release</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="banner_link" class="block my-1 text-sm font-medium text-gray-700">Banner Link (Url)</label>
                                    <input type="url" name="banner_link" id="banner_link" value="{{ $tvshows->banner_link }}"
                                        class="mt-1 block w-full rounded-md border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        placeholder="https://...">
                                </div>

                                <div>
                                    <label for="title" class="block my-1 text-sm font-medium text-gray-700">Show Title</label>
                                    <input type="text" name="title" id="title" required value="{{ $tvshows->title }}"
                                        class="mt-1 block w-full rounded-md @error('title') is-invalid @enderror border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @error('title')
                                        @foreach ($errors->get('title') as $message)
                                            <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}
                                            </div>
                                        @endforeach
                                    @enderror
                                </div>
                                <div>
                                    <label for="description"
                                        class="block my-1 text-sm font-medium text-gray-700">Description (English)</label>
                                    <textarea name="description" id="description" rows="3"
                                        class="mt-1 block w-full @error('description') is-invalid @enderror rounded-md  border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $tvshows->description }}</textarea>
                                    @error('description')
                                        @foreach ($errors->get('description') as $message)
                                            <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}
                                            </div>
                                        @endforeach
                                    @enderror
                                </div>
                                <div>
                                    <label for="content_description"
                                        class="block my-1 text-sm font-medium text-gray-700">Plot (Hindi)</label>
                                    <textarea name="content_description" id="content_description" rows="3"
                                        class="mt-1 block w-full @error('content_description') is-invalid @enderror rounded-md  border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $tvshows->content_description }}</textarea>
                                    @error('content_description')
                                        @foreach ($errors->get('content_description') as $message)
                                            <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}
                                            </div>
                                        @endforeach
                                    @enderror
                                </div>
                                <div>
                                    <label for="release_date" class="block my-1 text-sm font-medium text-gray-700">Release
                                        Date</label>
                                    <input type="date" name="release_date" id="release_date" value="{{ $tvshows->release_date?->format('Y-m-d') }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                    <div class="flex items-center">
                                        <input type="hidden" name="is_release_year_only" value="0">
                                        <input type="checkbox" name="is_release_year_only" id="is_release_year_only" value="1" {{ old('is_release_year_only', $tvshows->is_release_year_only) ? 'checked' : '' }} class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                                        <label for="is_release_year_only" class="block ml-2 text-sm text-gray-900">Show Year Only</label>
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
                                    <label class="block my-1 text-sm font-medium text-gray-700">Genres</label>
                                    <x-searchable-multiselect 
                                        :options="$genres" 
                                        :selected="old('genre_ids', $tvshows->genres->pluck('id')->toArray())" 
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

                                <div x-data="{ hours: 0, minutes: 0 }">
                                    <input type="hidden" name="duration" id="duration"  value="{{ $tvshows->duration }}"
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
                                 {{ !empty($tvshows->artists) ? json_encode($tvshows->artists->flatMap(function($artist) {
                                    $roles = $artist->pivot->artist_category_ids ?? [];
                                    if (empty($roles)) return [['artist' => $artist->id, 'role' => '']];
                                    return collect($roles)->map(function($roleId) use ($artist) {
                                        return [
                                            'artist' => $artist->id,
                                            'role' => $roleId
                                        ];
                                    });
                                })->values()) : '[]' }}

                                
                                <div x-data="{ 
                                     artistEntries: {{ json_encode($tvshows->artists->flatMap(function($artist) {
                                        $roles = $artist->pivot->artist_category_ids ?? [];
                                        if (empty($roles)) return [['artist' => $artist->id, 'role' => '']];
                                        return collect($roles)->map(function($roleId) use ($artist) {
                                            return [
                                                'artist' => $artist->id,
                                                'role' => $roleId
                                            ];
                                        });
                                    })->values()) }},
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
                                        <div class="mt-2 grid grid-cols-1 gap-2 sm:grid-cols-12">
                                            <select x-model="entry.artist" 
                                                    :name="'artists[' + index + '][artist_id]'" 
                                                    class="w-full p-2 border border-gray-300 rounded sm:col-span-5">
                                                <option value="">Select Artist</option>
                                                <template x-for="artist in artists" :key="artist.id">
                                                    <option :value="artist.id" x-text="artist.name"  :selected="entry.artist == artist.id"  ></option>
                                                </template>
                                            </select>
                                            
                                            <select x-model="entry.role" 
                                                    :name="'artists[' + index + '][role]'" 
                                                    class="w-full p-2 border border-gray-300 rounded sm:col-span-4">
                                                <option value="">Select Role</option>
                                                <template x-for="category in categories" :key="category.id">
                                                    <option :value="category.id" x-text="category.name"   :selected="entry.role == category.id"  ></option>
                                                </template>
                                            </select>
                                            
                                            <button type="button" 
                                                    @click="removeArtistEntry(index)"
                                                    class="w-full px-2 py-2 text-white bg-red-500 rounded hover:bg-red-600 sm:col-span-3 sm:w-auto">
                                                Remove
                                            </button>
                                        </div>
                                    </template>
                                
                                    <button type="button" 
                                            @click="addArtistEntry()"
                                            class="w-full px-4 py-2 mt-2 text-white bg-green-500 rounded hover:bg-green-600 sm:w-auto">
                                        Add Another Artist
                                    </button>
                                </div>
                                @error('artists')
                                    <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror



                                {{-- <div>
                                    <label for="director"
                                        class="block my-1 text-sm font-medium text-gray-700">Director</label>
                                    <input type="text" name="director" id="director"  value="{{ $tvshows->director }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                    @error('director')
                                        @foreach ($errors->get('director') as $message)
                                            <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}
                                            </div>
                                        @endforeach
                                    @enderror
                                </div> --}}


                                <div x-data="{ 
                                    regions: [], 
                                    selectedRegion: '{{ old('region_id', $tvshows->region_id) }}', 
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
                                                this.selectedRegion = data.region.id;
                                            })
                                            .catch(error => console.error('Error adding language:', error));
                            
                                        document.getElementById('region_other').value = ''; // Clear the input field
                                        $refs.regionInput.classList.add('hidden'); // Hide the input field
                                    } 
                                }" 
                                x-init="fetchRegions()"
                            >
                                <label for="region" class="block my-1 text-sm font-medium text-gray-700">Language</label>
                                <select name="region_id" id="region" 
                                    x-model="selectedRegion" 
                                    class="w-full p-2 my-2 border border-gray-300 rounded"
                                    @change="selectedRegion == 'other' ? $refs.regionInput.classList.remove('hidden') : $refs.regionInput.classList.add('hidden')">
                                    <option value="">Select</option>    
                                    <template x-for="region in regions" :key="region.id">
                                        <option :value="region.id"  style='text-transform: capitalize;' x-text="region.name" :selected="region.id == selectedRegion"></option>
                                    </template>
                                    <option value="other" :selected="selectedRegion === 'other'">Other</option>    
                                </select>
                                <div class="hidden" id="regionInput" x-ref="regionInput">
                                    <input type="text" id="region_other" name="region_other" placeholder="Enter Region" class="w-full p-2 my-2 border border-gray-300 rounded" value="{{ old('region_other', $tvshows->region_other) }}">
                                    <button type="button" @click="addRegion" class="w-full px-4 py-2 my-2 bg-blue-500 text-white rounded sm:w-auto">Add</button>
                                </div>
                            </div>
                            
                                <div>
                                    <label for="cbfc"
                                        class="block my-1 text-sm font-medium text-gray-700">CBFC</label>
                                    <select name="cbfc" id="cbfc" class="w-full p-2 my-2 border border-gray-300 rounded">
                                        <option value="U" {{ $tvshows->cbfc == 'U' ? 'selected' : '' }}>U</option>
                                        <option value="UA 7+" {{ $tvshows->cbfc == 'UA 7+' ? 'selected' : '' }}>UA 7+</option>
                                        <option value="UA 13+" {{ $tvshows->cbfc == 'UA 13+' ? 'selected' : '' }}>UA 13+</option>
                                        <option value="UA 16+" {{ $tvshows->cbfc == 'UA 16+' ? 'selected' : '' }}>UA 16+</option>
                                        <option value="A" {{ $tvshows->cbfc == 'A' ? 'selected' : '' }}>A (18+)</option>
                                        <option value="S" {{ $tvshows->cbfc == 'S' ? 'selected' : '' }}>S</option>
                                        <option value="NA" {{ $tvshows->cbfc == 'NA' ? 'selected' : '' }}>NA</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="cg_chartbusters_ratings" class="block my-1 text-sm font-medium text-gray-700">CG Chartbusters Ratings</label>
                                    <x-star-rating id="rating" class="block mt-1 w-full" name="cg_chartbusters_ratings" :value="$tvshows->cg_chartbusters_ratings ?? old('cg_chartbusters_ratings')" required></x-star-rating>
                                </div>
                                
                                {{-- <div>
                                    <label for="imdb_ratings" class="block my-1 text-sm font-medium text-gray-700">IMDB Ratings</label>
                                    <x-star-rating id="imdb_ratings" class="block mt-1 w-full" name="imdb_ratings" :value="$tvshows->imdb_ratings ?? old('imdb_ratings')" required></x-star-rating>
                                </div>


                                <div>
                                    <label for="cinematographer"
                                        class="block my-1 text-sm font-medium text-gray-700">Cinematographer</label>
                                    <input type="text" name="cinematographer" id="cinematographer"  value="{{ $tvshows->cinematographer }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="dop" class="block my-1 text-sm font-medium text-gray-700">DOP</label>
                                    <input type="text" name="dop" id="dop"  value="{{ $tvshows->dop }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="screen_play" class="block my-1 text-sm font-medium text-gray-700">Screen
                                        Play</label>
                                    <input type="text" name="screen_play" id="screen_play" value="{{ $tvshows->screen_play }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="writer_story_concept"
                                        class="block my-1 text-sm font-medium text-gray-700">Writer Story Concept</label>
                                    <textarea name="writer_story_concept" id="writer_story_concept" rows="3"  value=""
                                        class="w-full p-2 my-2 border border-gray-300 rounded">{{ $tvshows->writer_story_concept }}</textarea>
                                </div>

                                <div>
                                    <label for="male_lead" class="block my-1 text-sm font-medium text-gray-700">Male
                                        Lead</label>
                                    <input type="text" name="male_lead" id="male_lead" value="{{ $tvshows->male_lead }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="female_lead" class="block my-1 text-sm font-medium text-gray-700">Female
                                        Lead</label>
                                    <input type="text" name="female_lead" id="female_lead" value="{{ $tvshows->female_lead }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="support_artists"
                                        class="block my-1 text-sm font-medium text-gray-700">Support Artists</label>
                                    <input type="text" name="support_artists" id="support_artists" value="{{ $tvshows->support_artists }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>



                                <div>
                                    <label for="producer"
                                        class="block my-1 text-sm font-medium text-gray-700">Producer</label>
                                    <input type="text" name="producer" id="producer" value="{{ $tvshows->producer }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="songs"
                                        class="block my-1 text-sm font-medium text-gray-700">Songs</label>
                                    <input type="text" name="songs" id="songs" value="{{ $tvshows->songs }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>
                                <div>
                                    <label for="singer_male" class="block my-1 text-sm font-medium text-gray-700">Singer
                                        Male</label>
                                    <select name="singer_male" id="singer_male" class="w-full p-2 my-2 border border-gray-300 rounded">
                                        <option value="">Select Singer Male</option>
                                        @foreach ($singer_male as $singer)
                                            <option value="{{ $singer->id }}" {{ $tvshows->singer_male == $singer->id ? 'selected' : '' }}>{{ $singer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="singer_female" class="block my-1 text-sm font-medium text-gray-700">Singer
                                        Female</label>
                                    <select name="singer_female" id="singer_female" class="w-full p-2 my-2 border border-gray-300 rounded">
                                        <option value="">Select Singer Female</option>
                                        @foreach ($singer_female as $singer)
                                            <option value="{{ $singer->id }}" {{ $tvshows->singer_female == $singer->id ? 'selected' : '' }}>{{ $singer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="lyrics"
                                        class="block my-1 text-sm font-medium text-gray-700">Lyrics</label>
                                    <textarea name="lyrics" id="lyrics" rows="3"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">{{ $tvshows->lyrics }}</textarea>
                                </div>

                                <div>
                                    <label for="composition"
                                        class="block my-1 text-sm font-medium text-gray-700">Composition</label>
                                    <input type="text" name="composition" id="composition" value="{{ $tvshows->composition }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="mix_master" class="block my-1 text-sm font-medium text-gray-700">Mix
                                        Master</label>
                                    <input type="text" name="mix_master" id="mix_master"  value="{{ $tvshows->mix_master }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="music"
                                        class="block my-1 text-sm font-medium text-gray-700">Music</label>
                                    <input type="text" name="music" id="music" value="{{ $tvshows->music }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="recordists"
                                        class="block my-1 text-sm font-medium text-gray-700">Recordists</label>
                                    <input type="text" name="recordists" id="recordists" value="{{ $tvshows->recordists }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="audio_studio" class="block my-1 text-sm font-medium text-gray-700">Audio
                                        Studio</label>
                                    <input type="text" name="audio_studio" id="audio_studio"  value="{{ $tvshows->audio_studio }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>
                                <div>
                                    <label for="editor"
                                        class="block my-1 text-sm font-medium text-gray-700">Editor</label>
                                    <input type="text" name="editor" id="editor" value="{{ $tvshows->editor }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                    <div>
                                        <label for="video_studio"
                                            class="block my-1 text-sm font-medium text-gray-700">Video Studio</label>
                                        <input type="text" name="video_studio" id="video_studio" value="{{ $tvshows->video_studio }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>

                                    <div>
                                        <label for="vfx"
                                            class="block my-1 text-sm font-medium text-gray-700">VFX</label>
                                        <input type="text" name="vfx" id="vfx"  value="{{ $tvshows->vfx }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>

                                    <div>
                                        <label for="make_up" class="block my-1 text-sm font-medium text-gray-700">Make
                                            Up</label>
                                        <input type="text" name="make_up" id="make_up" value="{{ $tvshows->make_up }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>

                                    <div>
                                        <label for="poster_logo"
                                            class="block my-1 text-sm font-medium text-gray-700">Poster Logo</label>
                                        <input type="text" name="poster_logo" id="poster_logo"  value="{{ $tvshows->poster_logo }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>
                                    <div>
                                        <label for="production_banner"
                                            class="block my-1 text-sm font-medium text-gray-700">Production Banner</label>
                                        <input type="text" name="production_banner" id="production_banner" value="{{ $tvshows->production_banner }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>

                                    <div>
                                        <label for="drone"
                                            class="block my-1 text-sm font-medium text-gray-700">Drone</label>
                                        <input type="text" name="drone" id="drone" value="{{ $tvshows->drone }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>

                                    <div>
                                        <label for="others"
                                            class="block my-1 text-sm font-medium text-gray-700">Others</label>
                                        <input type="text" name="others" id="others"  value="{{ $tvshows->others }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div> --}}

                                    {{-- <div>
                                        <label for="content_description"
                                            class="block my-1 text-sm font-medium text-gray-700">Content
                                            Description</label>
                                        <textarea name="content_description" id="content_description" rows="3"
                                            class="w-full p-2 my-2 border border-gray-300 rounded"> {{ $tvshows->content_description }}</textarea>
                                    </div> --}}
                                    <div>
                                        <label for="trailer_url"
                                            class="block my-1 text-sm font-medium text-gray-700">Trailer URL</label>
                                        <textarea name="trailer_url" id="trailer_url" rows="3"
                                            class="w-full p-2 my-2 border border-gray-300 rounded"> {{ $tvshows->trailer_url }}</textarea>
                                        @error('trailer_url')
                                            @foreach ($errors->get('trailer_url') as $message)
                                                <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">
                                                    {{ $message }}</div>
                                            @endforeach
                                        @enderror
                                    </div>
                                    {{-- <div>
                                        <label for="hyperlinks_links"
                                            class="block my-1 text-sm font-medium text-gray-700">Hyperlinks Links</label>
                                        <input type="text" name="hyperlinks_links" id="hyperlinks_links"  value="{{ $tvshows->hyperlinks_links }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div> --}}
                                    
                                    <div>
                                        <label for="poster_image"
                                            class="block my-1 text-sm font-medium text-gray-700">Poster Image</label>
                                        <input type="file" name="poster_image" id="poster_image" accept="image/*"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                        @error('poster_image')
                                            @foreach ($errors->get('poster_image') as $message)
                                                <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">
                                                    {{ $message }}</div>
                                            @endforeach
                                        @enderror
                                    </div>
                                    
                                    
                                    <div>
                                        <label for="poster_image_landscape"
                                            class="block my-1 text-sm font-medium text-gray-700">Poster Image
                                            Landscape</label>
                                        <input type="file" name="poster_image_landscape" id="poster_image_landscape"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end px-4 py-3 bg-gray-50 sm:px-6">
                            <button type="submit"
                                class="inline-flex w-full justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection

