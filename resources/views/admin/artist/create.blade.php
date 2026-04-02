@extends('layouts.admin')

@section('page-title', 'Add New Artist')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight">ADD NEW ARTIST</h2>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Create a new profile for an artist</p>
        </div>
        <a href="{{ route('admin.artists.index') }}" class="px-4 py-2 bg-white border border-gray-100 rounded-xl text-[10px] font-black text-gray-400 uppercase tracking-widest hover:bg-gray-50 transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Back to Listing
        </a>
    </div>

    <form action="{{ route('admin.artists.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Basic Information -->
        <x-admin.form-section title="Basic Information" description="Artist name, bio and personal details">
            <x-admin.form-group label="Artist Name" for="name" required :error="$errors->first('name')">
                <x-admin.input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Full name of the artist" :error="$errors->has('name')" />
            </x-admin.form-group>

            <x-admin.form-group label="Birth Date" for="birth_date" :error="$errors->first('birth_date')">
                <x-admin.release-date
                    name="birth_date"
                    :value="old('birth_date')"
                    :year-only-value="old('is_release_year_only', false)"
                    label="Show Birth Year Only"
                    :error="$errors->first('birth_date')"
                />
            </x-admin.form-group>

            <x-admin.form-group label="City / Origin" for="city" :error="$errors->first('city')">
                <x-admin.input type="text" name="city" id="city" value="{{ old('city') }}" placeholder="e.g. Raipur, CG" />
            </x-admin.form-group>

            <x-admin.form-group label="Categories / Roles">
                @php $oldCategories = old('category', []); @endphp
                <div class="grid grid-cols-2 gap-3 mt-1">
                    @foreach($categories as $cat)
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50/30 hover:bg-white hover:shadow-sm transition-all cursor-pointer group">
                            <input type="checkbox" name="category[]" value="{{ $cat->id }}" 
                                {{ in_array($cat->id, (array)$oldCategories) ? 'checked' : '' }}
                                class="w-4 h-4 rounded border-gray-200 text-blue-600 focus:ring-blue-500/20">
                            <span class="text-[11px] font-black text-gray-400 group-hover:text-gray-700 uppercase tracking-widest transition-colors">{{ $cat->name }}</span>
                        </label>
                    @endforeach
                </div>
            </x-admin.form-group>

            <div class="md:col-span-2">
                <x-admin.form-group label="Biography (English)" for="bio" :error="$errors->first('bio')">
                    <x-admin.textarea name="bio" id="bio" rows="4">{{ old('bio') }}</x-admin.textarea>
                </x-admin.form-group>
            </div>

            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-admin.form-group label="Bio (Hindi)" for="bio_hi">
                    <x-admin.textarea name="bio_hi" id="bio_hi" rows="4">{{ old('bio_hi') }}</x-admin.textarea>
                </x-admin.form-group>
                <x-admin.form-group label="Bio (Chhattisgarhi)" for="bio_chh">
                    <x-admin.textarea name="bio_chh" id="bio_chh" rows="4">{{ old('bio_chh') }}</x-admin.textarea>
                </x-admin.form-group>
            </div>
        </x-admin.form-section>

        <!-- Media & Ratings -->
        <x-admin.form-section title="Artist Profile" description="Visual and social presence">
            <x-admin.form-group label="Profile Photo" help="High quality portrait image" required :error="$errors->first('photo')">
                <x-admin.file-upload name="photo" label="Artist Image" />
            </x-admin.form-group>

            <x-admin.form-group label="CGCB Rating">
                <div class="mt-1 bg-gray-50/50 p-3 rounded-xl border border-gray-100 shadow-inner">
                    <x-star-rating id="rating" name="cgcb_rating" :value="old('cgcb_rating', 0)"></x-star-rating>
                </div>
            </x-admin.form-group>
        </x-admin.form-section>

        <!-- Submit Bar -->
        <div class="sticky bottom-8 z-30 p-4 bg-white/80 backdrop-blur-md rounded-2xl border border-gray-100 shadow-2xl flex items-center justify-end gap-3">
            <button type="button" @click="window.history.back()" class="px-6 py-2.5 text-xs font-black text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-colors">
                Discard
            </button>
            <button type="submit" class="px-10 py-3 bg-blue-600 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-xl shadow-blue-200 hover:bg-blue-700 hover:shadow-blue-300 transition-all transform active:scale-95">
                Save Artist Profile
            </button>
        </div>
    </form>
</div>
@endsection
