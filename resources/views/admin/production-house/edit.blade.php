@extends('layouts.admin')

@section('page-title', 'Edit Production House - ' . $productionHouse->name)

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight">EDIT PRODUCTION HOUSE</h2>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Modify profile details for {{ $productionHouse->name }}</p>
        </div>
        <a href="{{ route('admin.productionhouses.index') }}" class="px-4 py-2 bg-white border border-gray-100 rounded-xl text-[10px] font-black text-gray-400 uppercase tracking-widest hover:bg-gray-50 transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Back to Listing
        </a>
    </div>

    @if (session('error'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-rose-500 text-white flex items-center justify-center shadow-lg shadow-rose-200">
                <i class="fas fa-exclamation-triangle text-xs"></i>
            </div>
            <p class="text-sm font-bold text-rose-600">{{ session('error') }}</p>
        </div>
    @endif

    <form action="{{ route('admin.productionhouses.update', $productionHouse->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <x-admin.form-section title="Basic Information" description="Production House name, founding details and location">
            <x-admin.form-group label="Production House Name" for="name" required :error="$errors->first('name')">
                <x-admin.input type="text" name="name" id="name" required value="{{ old('name', $productionHouse->name) }}" placeholder="e.g. CGI Chartbusters Studios" :error="$errors->has('name')" />
            </x-admin.form-group>

            <x-admin.form-group label="City / Origin" for="city" :error="$errors->first('city')">
                <x-admin.input type="text" name="city" id="city" value="{{ old('city', $productionHouse->city) }}" placeholder="e.g. Raipur, CG" />
            </x-admin.form-group>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:col-span-2">
                <x-admin.form-group label="Founded Year" for="founded_year" :error="$errors->first('founded_year')">
                    <x-admin.input type="number" name="founded_year" id="founded_year" value="{{ old('founded_year', $productionHouse->founded_year) }}" placeholder="e.g. 2015" />
                </x-admin.form-group>

                <x-admin.form-group label="Owner / Founder Name" for="owner_name" :error="$errors->first('owner_name')">
                    <x-admin.input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name', $productionHouse->owner_name) }}" placeholder="e.g. John Doe" />
                </x-admin.form-group>

                <x-admin.form-group label="Active Since" for="active_since" :error="$errors->first('active_since')">
                    <x-admin.input type="number" name="active_since" id="active_since" value="{{ old('active_since', $productionHouse->active_since) }}" placeholder="e.g. 2015" />
                </x-admin.form-group>
            </div>

            <div class="md:col-span-2">
                <x-admin.form-group label="Biography / Profile (English)" for="bio" :error="$errors->first('bio')">
                    <x-admin.textarea name="bio" id="bio" rows="4">{{ old('bio', $productionHouse->bio) }}</x-admin.textarea>
                </x-admin.form-group>
            </div>

            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-admin.form-group label="Bio (Hindi)" for="bio_hi">
                    <x-admin.textarea name="bio_hi" id="bio_hi" rows="4">{{ old('bio_hi', $productionHouse->bio_hi) }}</x-admin.textarea>
                </x-admin.form-group>
                <x-admin.form-group label="Bio (Chhattisgarhi)" for="bio_chh">
                    <x-admin.textarea name="bio_chh" id="bio_chh" rows="4">{{ old('bio_chh', $productionHouse->bio_chh) }}</x-admin.textarea>
                </x-admin.form-group>
            </div>
        </x-admin.form-section>

        <!-- Media & Assets -->
        <x-admin.form-section title="Media & Visual Assets" description="Upload studio logos and landscape cover banners">
            <x-admin.form-group label="Logo / Profile Photo" help="High quality square image/logo" :error="$errors->first('photo')">
                <x-admin.file-upload name="photo" label="Logo Image" :value="$productionHouse->photo" />
            </x-admin.form-group>

            <x-admin.form-group label="Cover Banner Image" help="Landscape banner image for the profile page" :error="$errors->first('banner_image')">
                <x-admin.file-upload name="banner_image" label="Banner Image" :value="$productionHouse->banner_image" />
            </x-admin.form-group>
        </x-admin.form-section>

        <!-- Social Presence & Verification -->
        <x-admin.form-section title="Social Presence & Credentials" description="Studio websites, channels, and rating configurations">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:col-span-2">
                <x-admin.form-group label="Official Website URL" for="website_url" :error="$errors->first('website_url')">
                    <x-admin.input type="text" name="website_url" id="website_url" value="{{ old('website_url', $productionHouse->website_url) }}" placeholder="https://example.com" />
                </x-admin.form-group>

                <x-admin.form-group label="YouTube Channel URL" for="youtube_url" :error="$errors->first('youtube_url')">
                    <x-admin.input type="text" name="youtube_url" id="youtube_url" value="{{ old('youtube_url', $productionHouse->youtube_url) }}" placeholder="https://youtube.com/..." />
                </x-admin.form-group>

                <x-admin.form-group label="Instagram Profile URL" for="instagram_url" :error="$errors->first('instagram_url')">
                    <x-admin.input type="text" name="instagram_url" id="instagram_url" value="{{ old('instagram_url', $productionHouse->instagram_url) }}" placeholder="https://instagram.com/..." />
                </x-admin.form-group>

                <x-admin.form-group label="Facebook Page URL" for="facebook_url" :error="$errors->first('facebook_url')">
                    <x-admin.input type="text" name="facebook_url" id="facebook_url" value="{{ old('facebook_url', $productionHouse->facebook_url) }}" placeholder="https://facebook.com/..." />
                </x-admin.form-group>

                <x-admin.form-group label="Twitter/X Profile URL" for="twitter_url" :error="$errors->first('twitter_url')">
                    <x-admin.input type="text" name="twitter_url" id="twitter_url" value="{{ old('twitter_url', $productionHouse->twitter_url) }}" placeholder="https://twitter.com/..." />
                </x-admin.form-group>

                <x-admin.form-group label="CGCB Studio Rating">
                    <div class="mt-1 bg-gray-50/50 p-3 rounded-xl border border-gray-100 shadow-inner">
                        <x-star-rating id="rating" name="cgcb_rating" :value="old('cgcb_rating', $productionHouse->cgcb_rating)"></x-star-rating>
                    </div>
                </x-admin.form-group>
            </div>

            <div class="grid grid-cols-2 gap-6 md:col-span-2 mt-4">
                <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50/30 hover:bg-white hover:shadow-sm transition-all cursor-pointer group">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $productionHouse->is_featured) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-200 text-blue-600 focus:ring-blue-500/20">
                    <div class="flex flex-col">
                        <span class="text-[11px] font-black text-gray-400 group-hover:text-gray-700 uppercase tracking-widest transition-colors">Featured Flag</span>
                        <span class="text-[9px] text-gray-400">Promote this studio/production house on homepage or listings</span>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50/30 hover:bg-white hover:shadow-sm transition-all cursor-pointer group">
                    <input type="checkbox" name="is_verified" value="1" {{ old('is_verified', $productionHouse->is_verified) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-200 text-blue-600 focus:ring-blue-500/20">
                    <div class="flex flex-col">
                        <span class="text-[11px] font-black text-gray-400 group-hover:text-gray-700 uppercase tracking-widest transition-colors">Verification Badge</span>
                        <span class="text-[9px] text-gray-400">Display verified badge next to the studio name</span>
                    </div>
                </label>
            </div>
        </x-admin.form-section>

        <!-- Submit Bar -->
        <div class="sticky bottom-8 z-30 p-4 bg-white/80 backdrop-blur-md rounded-2xl border border-gray-100 shadow-2xl flex items-center justify-end gap-3">
            <button type="button" @click="window.history.back()" class="px-6 py-2.5 text-xs font-black text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-colors">
                Discard
            </button>
            <button type="submit" class="px-10 py-3 bg-blue-600 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-xl shadow-blue-200 hover:bg-blue-700 hover:shadow-blue-300 transition-all transform active:scale-95">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
