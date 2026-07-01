<x-app-layout>
@section('meta_title', 'Submit a TV Show — CG Chartbusters')

<div class="py-12 bg-black min-h-screen text-white">
    <div class="max-w-5xl mx-auto px-4 space-y-8">
        <div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">Submit a <span class="text-yellow-400">TV Show</span></h1>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Fill in the details — our team will review and publish</p>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-900/30 border border-green-500/50 rounded-2xl text-green-400 text-sm font-medium">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="p-4 bg-red-955/10 border border-red-500/50 rounded-2xl text-red-400 text-sm">
                <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('submit.tvshow.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <x-admin.form-section title="Basic Information" description="Core TV show details" class="bg-gray-900 border-gray-800 text-white">
                <x-admin.form-group label="TV Show Title" for="title" required :error="$errors->first('title')">
                    <x-admin.input type="text" name="title" id="title" required value="{{ old('title') }}" placeholder="Enter TV show title" :error="$errors->has('title')" class="bg-gray-850 border-gray-700 text-white" />
                </x-admin.form-group>

                <x-admin.form-group label="Release Date" for="release_date">
                    <x-admin.release-date :value="old('release_date')" :year-only-value="old('is_release_year_only', false)" />
                </x-admin.form-group>

                <div class="md:col-span-2">
                    <x-admin.form-group label="Description" for="description">
                        <x-admin.textarea name="description" id="description" rows="3" placeholder="Short description..." class="bg-gray-850 border-gray-700 text-white">{{ old('description') }}</x-admin.textarea>
                    </x-admin.form-group>
                </div>
            </x-admin.form-section>

            <x-admin.form-section title="Media Assets" description="Posters and trailer" class="bg-gray-900 border-gray-800 text-white">
                <x-admin.form-group label="Poster (Portrait)">
                    <x-admin.file-upload name="poster_image" label="Portrait Poster" />
                </x-admin.form-group>
                <x-admin.form-group label="Poster (Landscape)">
                    <x-admin.file-upload name="poster_image_landscape" label="Landscape Poster" />
                </x-admin.form-group>
                <div class="md:col-span-2">
                    <x-admin.form-group label="Trailer URL" for="trailer_url">
                        <x-admin.input type="url" name="trailer_url" id="trailer_url" value="{{ old('trailer_url') }}" placeholder="https://youtube.com/watch?v=..." class="bg-gray-850 border-gray-700 text-white" />
                    </x-admin.form-group>
                </div>
            </x-admin.form-section>

            <x-admin.form-section title="Metadata" description="Genres, region, director, and cast" class="bg-gray-900 border-gray-800 text-white">
                <x-admin.form-group label="Genres">
                    <x-searchable-multiselect :options="$genres" :selected="old('genre_ids', [])" name="genre_ids" placeholder="Select Genres" />
                </x-admin.form-group>

                <x-admin.form-group label="Language / Region" for="region_id">
                    <x-admin.select name="region_id" id="region_id" class="bg-gray-850 border-gray-700 text-white">
                        <option value="">Select Language</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                        @endforeach
                    </x-admin.select>
                </x-admin.form-group>

                <x-admin.form-group label="Director" for="director">
                    <x-admin.input type="text" name="director" id="director" value="{{ old('director') }}" placeholder="Director name" class="bg-gray-850 border-gray-700 text-white" />
                </x-admin.form-group>

                <x-admin.form-group label="Production House" for="production_house_id">
                    <x-admin.select name="production_house_id" id="production_house_id" class="bg-gray-850 border-gray-700 text-white">
                        <option value="">Select Production House</option>
                        @foreach($productionHouses as $ph)
                            <option value="{{ $ph->id }}" {{ old('production_house_id') == $ph->id ? 'selected' : '' }}>{{ $ph->name }}</option>
                        @endforeach
                    </x-admin.select>
                </x-admin.form-group>

                <div class="md:col-span-2">
                    <x-admin.form-group label="Artists & Roles">
                        <div x-data="{ artistEntries: [{ artist: '', role: '' }], artists: {{ $artists->toJson() }}, categories: {{ $categories->toJson() }}, addArtistEntry() { this.artistEntries.push({ artist: '', role: '' }); }, removeArtistEntry(i) { this.artistEntries.splice(i, 1); } }" class="space-y-4">
                            <template x-for="(entry, index) in artistEntries" :key="index">
                                <div class="p-4 border border-gray-800 rounded-2xl bg-gray-900/50 flex flex-col md:flex-row gap-4 items-end">
                                    <div class="flex-1 w-full">
                                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5 block">Artist</label>
                                        <x-admin.select x-model="entry.artist" x-bind:name="'artists[' + index + '][artist_id]'" class="bg-gray-850 border-gray-700 text-white">
                                            <option value="">Choose Artist</option>
                                            <template x-for="a in artists" :key="a.id"><option :value="a.id" x-text="a.name"></option></template>
                                        </x-admin.select>
                                    </div>
                                    <div class="flex-1 w-full">
                                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5 block">Role</label>
                                        <x-admin.select x-model="entry.role" x-bind:name="'artists[' + index + '][role]'" class="bg-gray-850 border-gray-700 text-white">
                                            <option value="">Choose Role</option>
                                            <template x-for="c in categories" :key="c.id"><option :value="c.id" x-text="c.name"></option></template>
                                        </x-admin.select>
                                    </div>
                                    <button type="button" @click="removeArtistEntry(index)" class="w-12 h-12 rounded-xl bg-rose-955/30 border border-rose-500/30 text-rose-400 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all shrink-0">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </div>
                            </template>
                            <button type="button" @click="addArtistEntry()" class="w-full py-4 border-2 border-dashed border-gray-800 rounded-2xl text-[10px] font-black text-gray-400 uppercase tracking-widest hover:border-yellow-500/30 hover:text-yellow-500 transition-all flex items-center justify-center">
                                <i class="fas fa-plus mr-2"></i> Add Artist
                            </button>
                        </div>
                    </x-admin.form-group>
                </div>
            </x-admin.form-section>

            <div class="sticky bottom-8 z-30 p-4 bg-gray-900/80 backdrop-blur-md rounded-2xl border border-gray-800 shadow-2xl flex items-center justify-between">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-2">Submission will be reviewed before publishing</p>
                <button type="submit" class="px-10 py-3 bg-yellow-500 hover:bg-yellow-400 text-black rounded-xl text-xs font-black uppercase tracking-widest shadow-xl shadow-yellow-500/10 transition-all transform active:scale-95">Submit for Review</button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
