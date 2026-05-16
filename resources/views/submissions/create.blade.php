<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-xl sm:rounded-lg border border-gray-800">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h1 class="text-3xl font-bold text-white">Add Your Content</h1>
                            <p class="mt-2 text-gray-400">Submit your creation to be featured on CG Chartbusters.</p>
                        </div>
                        <div class="hidden md:block">
                            <i class="fas fa-upload text-5xl text-yellow-500 opacity-20"></i>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-900/30 border border-green-800 text-green-400 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Content Type -->
                            <div>
                                <label for="content_type" class="block text-sm font-medium text-gray-300">Content Type <span class="text-red-500">*</span></label>
                                <select id="content_type" name="content_type" required class="mt-2 block w-full bg-gray-800 border-gray-700 text-white rounded-lg shadow-sm focus:border-yellow-500 focus:ring-yellow-500 py-3 px-4 transition-all">
                                    <option value="">Select Type</option>
                                    <option value="Movie" {{ old('content_type') == 'Movie' ? 'selected' : '' }}>Movie</option>
                                    <option value="Song" {{ old('content_type') == 'Song' ? 'selected' : '' }}>Song</option>
                                    <option value="TV Show" {{ old('content_type') == 'TV Show' ? 'selected' : '' }}>TV Show</option>
                                    <option value="Artist" {{ old('content_type') == 'Artist' ? 'selected' : '' }}>Artist</option>
                                    <option value="Event" {{ old('content_type') == 'Event' ? 'selected' : '' }}>Event</option>
                                    <option value="Other" {{ old('content_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('content_type') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-300">Title / Name <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required class="mt-2 block w-full bg-gray-800 border-gray-700 text-white rounded-lg shadow-sm focus:border-yellow-500 focus:ring-yellow-500 py-3 px-4 transition-all" placeholder="e.g. My Awesome Song">
                                @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-300">Description</label>
                            <textarea name="description" id="description" rows="4" class="mt-2 block w-full bg-gray-800 border-gray-700 text-white rounded-lg shadow-sm focus:border-yellow-500 focus:ring-yellow-500 py-3 px-4 transition-all" placeholder="Tell us more about your content...">{{ old('description') }}</textarea>
                            @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- External Link -->
                            <div>
                                <label for="external_link" class="block text-sm font-medium text-gray-300">External Link (YouTube/Spotify/etc.)</label>
                                <input type="url" name="external_link" id="external_link" value="{{ old('external_link') }}" class="mt-2 block w-full bg-gray-800 border-gray-700 text-white rounded-lg shadow-sm focus:border-yellow-500 focus:ring-yellow-500 py-3 px-4 transition-all" placeholder="https://youtube.com/...">
                                @error('external_link') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Media Upload -->
                            <div>
                                <label for="media_file" class="block text-sm font-medium text-gray-300">Upload Poster / Image / Media</label>
                                <input type="file" name="media_file" id="media_file" class="mt-2 block w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-6 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-yellow-600 file:text-white hover:file:bg-yellow-700 transition-all cursor-pointer">
                                <p class="mt-2 text-xs text-gray-500">Max size: 10MB (JPG, PNG, MP4, MP3)</p>
                                @error('media_file') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-300">Category</label>
                                <input type="text" name="category" id="category" value="{{ old('category') }}" class="mt-2 block w-full bg-gray-800 border-gray-700 text-white rounded-lg shadow-sm focus:border-yellow-500 focus:ring-yellow-500 py-3 px-4 transition-all" placeholder="e.g. Action, Romantic, Pop">
                                @error('category') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Tags -->
                            <div>
                                <label for="tags" class="block text-sm font-medium text-gray-300">Tags</label>
                                <input type="text" name="tags" id="tags" value="{{ old('tags') }}" class="mt-2 block w-full bg-gray-800 border-gray-700 text-white rounded-lg shadow-sm focus:border-yellow-500 focus:ring-yellow-500 py-3 px-4 transition-all" placeholder="e.g. cgmusic, newrelease, 2024">
                                @error('tags') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- T&C -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms_accepted" name="terms_accepted" type="checkbox" required class="focus:ring-yellow-500 h-4 w-4 text-yellow-600 border-gray-700 bg-gray-800 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms_accepted" class="font-medium text-gray-300">I agree to the <a href="{{ route('terms-and-conditions') }}" class="text-yellow-500 hover:underline">Terms & Conditions</a></label>
                                @error('terms_accepted') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-black bg-yellow-500 hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                                Submit Content for Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
