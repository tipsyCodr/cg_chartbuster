@extends('layouts.admin')

@section('page-title', 'Edit Movie: ' . $movie->title)

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight uppercase">EDIT: {{ $movie->title }}</h2>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Update movie details and media</p>
        </div>
        <a href="{{ route('admin.movies.index') }}" class="px-4 py-2 bg-white border border-gray-100 rounded-xl text-[10px] font-black text-gray-400 uppercase tracking-widest hover:bg-gray-50 transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Back to Listing
        </a>
    </div>

    <form action="{{ route('admin.movies.update', $movie) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <x-admin.form-section title="Basic Information" description="Standard movie details and plot information">
            <x-admin.form-group label="Movie Title" for="title" required :error="$errors->first('title')">
                <x-admin.input type="text" name="title" id="title" required value="{{ old('title', $movie->title) }}" placeholder="Enter movie title" :error="$errors->has('title')" />
            </x-admin.form-group>

            <x-admin.form-group label="Release Date" for="release_date" :error="$errors->first('release_date')">
                <x-admin.release-date
                    :value="old('release_date', $movie->release_date?->format('Y-m-d'))"
                    :year-only-value="old('is_release_year_only', $movie->is_release_year_only)"
                    :error="$errors->first('release_date')"
                />
            </x-admin.form-group>

            <x-admin.form-group label="Duration" for="duration" :error="$errors->first('duration')">
                <x-admin.input type="time" name="duration" id="duration" value="{{ old('duration', $movie->duration ? substr((string) $movie->duration, 0, 5) : '') }}" :error="$errors->has('duration')" />
            </x-admin.form-group>

            <div class="md:col-span-2">
                <x-admin.form-group label="Short Description (English)" for="description" :error="$errors->first('description')">
                    <x-admin.textarea name="description" id="description" rows="3" placeholder="Enter short movie description...">{{ old('description', $movie->description) }}</x-admin.textarea>
                </x-admin.form-group>
            </div>

            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-admin.form-group label="Plot (Hindi)" for="content_description">
                    <x-admin.textarea name="content_description" id="content_description" rows="3">{{ old('content_description', $movie->content_description) }}</x-admin.textarea>
                </x-admin.form-group>
                <x-admin.form-group label="Plot (Chhattisgarhi)" for="content_description_chh">
                    <x-admin.textarea name="content_description_chh" id="content_description_chh" rows="3">{{ old('content_description_chh', $movie->content_description_chh) }}</x-admin.textarea>
                </x-admin.form-group>
            </div>
        </x-admin.form-section>

        <!-- Media Assets -->
        <x-admin.form-section title="Media Assets" description="Posters, banners, and trailer URLs">
            <x-admin.form-group label="Poster (Portrait)" help="Best for thumbnail and mobile views">
                <x-admin.file-upload name="poster_image" label="Portrait Poster" :current="$movie->poster_image" />
            </x-admin.form-group>

            <x-admin.form-group label="Poster (Landscape)" help="Best for hero and desktop banners">
                <x-admin.file-upload name="poster_image_landscape" label="Landscape Poster" :current="$movie->poster_image_landscape" />
            </x-admin.form-group>

            <div class="md:col-span-2">
                <x-admin.form-group label="Trailer URL" for="trailer_url" :error="$errors->first('trailer_url')" help="Direct link to YouTube or Vimeo trailer">
                    <x-admin.input type="url" name="trailer_url" id="trailer_url" value="{{ old('trailer_url', $movie->trailer_url) }}" placeholder="https://youtube.com/watch?v=..." />
                </x-admin.form-group>
            </div>
        </x-admin.form-section>

        <!-- Metadata & Classification -->
        <x-admin.form-section title="Metadata" description="Cast, genres, and ratings for better discovery">
            <x-admin.form-group label="Genres" required>
                <div class="mt-1">
                    <x-searchable-multiselect 
                        :options="$genres" 
                        :selected="old('genre_ids', $movie->genres->pluck('id')->toArray())" 
                        name="genre_ids" 
                        placeholder="Select Genres" 
                    />
                </div>
            </x-admin.form-group>

            <x-admin.form-group label="Language / Region" for="region_id" :error="$errors->first('region_id')">
                <x-admin.select name="region_id" id="region_id" :error="$errors->has('region_id')">
                    <option value="">Select Language</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}" {{ old('region_id', $movie->region_id) == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                    @endforeach
                </x-admin.select>
            </x-admin.form-group>

            <x-admin.form-group label="CBFC Rating" for="cbfc">
                <x-admin.select name="cbfc" id="cbfc">
                    @foreach(['U', 'UA 7+', 'UA 13+', 'UA 16+', 'A', 'S', 'NA'] as $rating)
                        <option value="{{ $rating }}" {{ old('cbfc', $movie->cbfc) == $rating ? 'selected' : '' }}>{{ $rating }}</option>
                    @endforeach
                </x-admin.select>
            </x-admin.form-group>

            <x-admin.form-group label="CG Chartbusters Rating">
                <div class="mt-1 bg-gray-50/50 p-3 rounded-xl border border-gray-100 shadow-inner">
                    <x-star-rating id="rating" name="cg_chartbusters_ratings" :value="old('cg_chartbusters_ratings', $movie->cg_chartbusters_ratings ?? 0)"></x-star-rating>
                </div>
            </x-admin.form-group>


            <div class="md:col-span-2">
                <x-admin.form-group label="Artists & Roles" help="Assign artists and their specific roles in this movie">
                    @php
                        $currentArtists = $movie->artists->flatMap(function($artist) {
                            $roles = $artist->pivot->artist_category_ids ?? [];
                            if (empty($roles)) return [['artist' => (string)$artist->id, 'role' => '']];
                            return collect($roles)->map(function($roleId) use ($artist) {
                                return ['artist' => (string)$artist->id, 'role' => (string)$roleId];
                            });
                        })->values();
                    @endphp
                    <div x-data="{ 
                        artistEntries: {{ $currentArtists->count() > 0 ? $currentArtists->toJson() : '[{ artist: \'\', role: \'\' }]' }},
                        artists: {{ $artists->toJson() }},
                        categories: {{ $categories->toJson() }},
                        addArtistEntry() { this.artistEntries.push({ artist: '', role: '' }); },
                        removeArtistEntry(index) { this.artistEntries.splice(index, 1); }
                    }" class="space-y-4">
                        <template x-for="(entry, index) in artistEntries" :key="index">
                            <div class="p-4 border border-gray-100 rounded-2xl bg-gray-50/50 flex flex-col md:flex-row gap-4 items-end animate-in fade-in slide-in-from-top-2 duration-300">
                                <div class="flex-1 w-full">
                                    <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5 block">Select Artist</label>
                                    <x-admin.select x-model="entry.artist" x-bind:name="'artists[' + index + '][artist_id]'">
                                        <option value="">Choose Artist</option>
                                        <template x-for="artist in artists" :key="artist.id">
                                            <option :value="artist.id" x-text="artist.name" :selected="entry.artist == artist.id"></option>
                                        </template>
                                    </x-admin.select>
                                </div>
                                <div class="flex-1 w-full">
                                    <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5 block">Select Role</label>
                                    <x-admin.select x-model="entry.role" x-bind:name="'artists[' + index + '][role]'">
                                        <option value="">Choose Role</option>
                                        <template x-for="category in categories" :key="category.id">
                                            <option :value="category.id" x-text="category.name" :selected="entry.role == category.id"></option>
                                        </template>
                                    </x-admin.select>
                                </div>
                                <button type="button" @click="removeArtistEntry(index)" class="w-12 h-12 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-sm shrink-0 mb-0.5">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </div>
                        </template>
                        <button type="button" @click="addArtistEntry()" class="w-full py-4 border-2 border-dashed border-gray-100 rounded-2xl text-[10px] font-black text-gray-400 uppercase tracking-widest hover:border-blue-500/30 hover:text-blue-500 transition-all flex items-center justify-center">
                            <i class="fas fa-plus mr-2"></i> Add Another Artist Entry
                        </button>
                    </div>
                </x-admin.form-group>
            </div>
        </x-admin.form-section>

        <!-- Banner Promotions -->
        <x-admin.form-section title="Promotions" description="Banner display and calls to action">
            <x-admin.form-group label="Show on Banner">
                <x-admin.select name="show_on_banner">
                    <option value="0" {{ old('show_on_banner', $movie->show_on_banner) == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ old('show_on_banner', $movie->show_on_banner) == 1 ? 'selected' : '' }}>Yes</option>
                </x-admin.select>
            </x-admin.form-group>

            <x-admin.form-group label="Banner Label">
                <x-admin.select name="banner_label">
                    <option value="" {{ empty($movie->banner_label) ? 'selected' : '' }}>None</option>
                    <option value="🎬 Watch on Official YouTube Channel" {{ $movie->banner_label == '🎬 Watch on Official YouTube Channel' ? 'selected' : '' }}>🎬 Watch on Official YouTube Channel</option>
                    <option value="🎥 Watch in Theaters" {{ $movie->banner_label == '🎥 Watch in Theaters' ? 'selected' : '' }}>🎥 Watch in Theaters</option>
                    <option value="🔜 Upcoming Release" {{ $movie->banner_label == '🔜 Upcoming Release' ? 'selected' : '' }}>🔜 Upcoming Release</option>
                </x-admin.select>
            </x-admin.form-group>

            <div class="md:col-span-2">
                <x-admin.form-group label="Banner Link (Action URL)">
                    <x-admin.input type="url" name="banner_link" value="{{ old('banner_link', $movie->banner_link) }}" placeholder="https://..." />
                </x-admin.form-group>
            </div>
        </x-admin.form-section>

        <!-- Submit Bar -->
        <div class="sticky bottom-8 z-30 p-4 bg-white/80 backdrop-blur-md rounded-2xl border border-gray-100 shadow-2xl flex items-center justify-between">
            <div class="flex items-center gap-2 text-[10px] font-black text-gray-400 uppercase tracking-widest pl-2">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                Last updated {{ $movie->updated_at->diffForHumans() }}
            </div>
            <div class="flex items-center gap-3">
                <button type="button" @click="window.history.back()" class="px-6 py-2.5 text-xs font-black text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-10 py-3 bg-blue-600 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-xl shadow-blue-200 hover:bg-blue-700 hover:shadow-blue-300 transition-all transform active:scale-95">
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
