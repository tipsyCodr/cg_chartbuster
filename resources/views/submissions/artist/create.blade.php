<x-app-layout>
    @section('meta_title', 'Submit an Artist — CG Chartbusters')

    <div class="py-12 bg-black min-h-screen text-white">
        <div class="max-w-4xl mx-auto px-4 space-y-8">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Submit an <span
                        class="text-yellow-400">Artist</span></h1>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Fill in the details — our team
                    will review and publish</p>
            </div>

            @if (session('success'))
                <div
                    class="p-4 bg-green-900/30 border border-green-500/50 rounded-2xl text-green-400 text-sm font-medium">
                    {{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="p-4 bg-red-955/10 border border-red-500/50 rounded-2xl text-red-400 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <style>
                select {
                    color: black !important;
                }

                input,
                textarea {
                    color: black !important;
                }
            </style>
            <form action="{{ route('submit.artist.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                @csrf

                <x-admin.form-section title="Basic Information" description="Artist identity"
                    class="bg-gray-900 border-gray-800 text-white">
                    <x-admin.form-group label="Artist / Entity Name" for="name" required :error="$errors->first('name')">
                        <x-admin.input type="text" name="name" id="name" required value="{{ old('name') }}"
                            placeholder="Full name or entity name" :error="$errors->has('name')"
                            class="bg-gray-850 border-gray-700 text-white" />
                    </x-admin.form-group>

                    <x-admin.form-group label="Category" for="category">
                        <x-admin.select name="category[]" id="category" multiple
                            class="min-h-[80px] bg-gray-850 border-gray-700 text-white">
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ in_array($cat->id, old('category', [])) ? 'selected' : '' }}>{{ $cat->name }}
                                </option>
                            @endforeach
                        </x-admin.select>
                    </x-admin.form-group>

                    <x-admin.form-group label="Birth / Founded Date" for="birth_date">
                        <x-admin.release-date :value="old('birth_date')" :year-only-value="old('is_release_year_only', false)" />
                    </x-admin.form-group>

                    <x-admin.form-group label="City" for="city">
                        <x-admin.input type="text" name="city" id="city" value="{{ old('city') }}"
                            placeholder="City" class="bg-gray-850 border-gray-700 text-white" />
                    </x-admin.form-group>

                    <div class="md:col-span-2">
                        <x-admin.form-group label="Biography (English)" for="bio">
                            <x-admin.textarea name="bio" id="bio" rows="4"
                                placeholder="Artist biography..."
                                class="bg-gray-850 border-gray-700 text-white">{{ old('bio') }}</x-admin.textarea>
                        </x-admin.form-group>
                    </div>
                </x-admin.form-section>

                <x-admin.form-section title="Media" description="Photo and banner image"
                    class="bg-gray-900 border-gray-800 text-white">
                    <x-admin.form-group label="Profile Photo" help="Optional — admin can add later">
                        <x-admin.file-upload name="photo" label="Profile Photo" />
                    </x-admin.form-group>

                    <x-admin.form-group label="Banner Image">
                        <x-admin.file-upload name="banner_image" label="Banner Image" />
                    </x-admin.form-group>
                </x-admin.form-section>

                <x-admin.form-section title="Social Links" description="Online presence"
                    class="bg-gray-900 border-gray-800 text-white">
                    <x-admin.form-group label="Website" for="website_url">
                        <x-admin.input type="url" name="website_url" id="website_url"
                            value="{{ old('website_url') }}" placeholder="https://..."
                            class="bg-gray-850 border-gray-700 text-white" />
                    </x-admin.form-group>
                    <x-admin.form-group label="YouTube" for="youtube_url">
                        <x-admin.input type="url" name="youtube_url" id="youtube_url"
                            value="{{ old('youtube_url') }}" placeholder="https://youtube.com/@..."
                            class="bg-gray-850 border-gray-700 text-white" />
                    </x-admin.form-group>
                    <x-admin.form-group label="Instagram" for="instagram_url">
                        <x-admin.input type="url" name="instagram_url" id="instagram_url"
                            value="{{ old('instagram_url') }}" placeholder="https://instagram.com/..."
                            class="bg-gray-850 border-gray-700 text-white" />
                    </x-admin.form-group>
                    <x-admin.form-group for="facebook_url" label="Facebook">
                        <x-admin.input type="url" name="facebook_url" id="facebook_url"
                            value="{{ old('facebook_url') }}" placeholder="https://facebook.com/..."
                            class="bg-gray-850 border-gray-700 text-white" />
                    </x-admin.form-group>
                </x-admin.form-section>

                <div
                    class="sticky bottom-8 z-30 p-4 bg-gray-900/80 backdrop-blur-md rounded-2xl border border-gray-800 shadow-2xl flex items-center justify-between">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-2">Submission will be
                        reviewed before publishing</p>
                    <button type="submit"
                        class="px-10 py-3 bg-yellow-500 hover:bg-yellow-400 text-black rounded-xl text-xs font-black uppercase tracking-widest shadow-xl shadow-yellow-500/10 transition-all transform active:scale-95">Submit
                        for Review</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
