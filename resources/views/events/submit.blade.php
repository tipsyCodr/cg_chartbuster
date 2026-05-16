<x-app-layout>
    @section('meta_title', 'Submit Your Event - CG Chartbusters')

    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-extrabold text-white mb-4">Submit Your <span class="text-yellow-400">Event</span></h1>
                <p class="text-gray-400">Join the Chhollywood ecosystem by listing your event for thousands of cultural enthusiasts.</p>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-[2.5rem] p-8 md:p-12 shadow-2xl">
                @if ($errors->any())
                    <div class="mb-8 p-4 bg-red-500/10 border border-red-500/50 rounded-2xl">
                        <ul class="list-disc list-inside text-sm text-red-400">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                    @csrf

                    <!-- Basic Information -->
                    <section>
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <span class="w-8 h-8 rounded-full bg-yellow-400 text-black flex items-center justify-center text-sm">1</span>
                            Basic Information
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-400 mb-2">Event Title *</label>
                                <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g., 5th Annual Chhattisgarhi Film Awards"
                                    class="w-full bg-black border border-gray-700 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all">
                                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-400 mb-2">Event Type *</label>
                                <select name="event_type" required class="w-full bg-black border border-gray-700 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-yellow-400 transition-all">
                                    <option value="">Select Type</option>
                                    <option value="Film Premiere">Film Premiere</option>
                                    <option value="Award Ceremony">Award Ceremony</option>
                                    <option value="Music Concert">Music Concert</option>
                                    <option value="Workshop">Workshop</option>
                                    <option value="Cultural Festival">Cultural Festival</option>
                                    <option value="Audition">Audition</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('event_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-400 mb-2">Event Mode *</label>
                                <select name="event_mode" required class="w-full bg-black border border-gray-700 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-yellow-400 transition-all">
                                    <option value="Offline">Offline (In-person)</option>
                                    <option value="Online">Online (Virtual)</option>
                                    <option value="Hybrid">Hybrid</option>
                                </select>
                            </div>
                        </div>
                    </section>

                    <!-- Date & Location -->
                    <section>
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <span class="w-8 h-8 rounded-full bg-yellow-400 text-black flex items-center justify-center text-sm">2</span>
                            Date & Location
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-400 mb-2">Date *</label>
                                <input type="date" name="event_date" value="{{ old('event_date') }}" required
                                    class="w-full bg-black border border-gray-700 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-yellow-400 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-400 mb-2">Start Time *</label>
                                <input type="time" name="start_time" value="{{ old('start_time') }}" required
                                    class="w-full bg-black border border-gray-700 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-yellow-400 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-400 mb-2">End Time *</label>
                                <input type="time" name="end_time" value="{{ old('end_time') }}" required
                                    class="w-full bg-black border border-gray-700 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-yellow-400 transition-all">
                            </div>

                            <div class="md:col-span-3">
                                <label class="block text-sm font-bold text-gray-400 mb-2">Venue / Platform URL *</label>
                                <input type="text" name="venue" value="{{ old('venue') }}" required placeholder="e.g., Muktakash Mancha, Raipur"
                                    class="w-full bg-black border border-gray-700 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-yellow-400 transition-all">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-400 mb-2">City *</label>
                                <input type="text" name="city" value="{{ old('city') }}" required placeholder="Raipur"
                                    class="w-full bg-black border border-gray-700 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-yellow-400 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-400 mb-2">State *</label>
                                <input type="text" name="state" value="{{ old('state', 'Chhattisgarh') }}" required
                                    class="w-full bg-black border border-gray-700 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-yellow-400 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-400 mb-2">Registration Deadline</label>
                                <input type="date" name="registration_deadline" value="{{ old('registration_deadline') }}"
                                    class="w-full bg-black border border-gray-700 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-yellow-400 transition-all">
                            </div>
                        </div>
                    </section>

                    <!-- Organizer & Media -->
                    <section>
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <span class="w-8 h-8 rounded-full bg-yellow-400 text-black flex items-center justify-center text-sm">3</span>
                            Organizer & Details
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-400 mb-2">Organizer Name *</label>
                                <input type="text" name="organizer_name" value="{{ old('organizer_name') }}" required
                                    class="w-full bg-black border border-gray-700 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-yellow-400 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-400 mb-2">Contact Email *</label>
                                <input type="email" name="contact_email" value="{{ old('contact_email') }}" required
                                    class="w-full bg-black border border-gray-700 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-yellow-400 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-400 mb-2">Contact Phone</label>
                                <input type="text" name="contact_phone" value="{{ old('contact_phone') }}" placeholder="+91 ..."
                                    class="w-full bg-black border border-gray-700 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-yellow-400 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-400 mb-2">Registration Link (URL)</label>
                                <input type="url" name="registration_link" value="{{ old('registration_link') }}" placeholder="https://..."
                                    class="w-full bg-black border border-gray-700 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-yellow-400 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-400 mb-2">Entry Fee *</label>
                                <input type="text" name="entry_fee" value="{{ old('entry_fee', 'Free') }}" required
                                    class="w-full bg-black border border-gray-700 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-yellow-400 transition-all">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-400 mb-2">Event Description * (Min 50 words)</label>
                                <textarea name="description" rows="6" required placeholder="Tell us about the event highlights, guests, and schedule..."
                                    class="w-full bg-black border border-gray-700 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-yellow-400 transition-all">{{ old('description') }}</textarea>
                                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-400 mb-2">Event Poster * (Recommended 1280x720, Max 2MB)</label>
                                <div 
                                    x-data="{ 
                                        isDragging: false, 
                                        preview: null,
                                        handleDrop(e) {
                                            this.isDragging = false;
                                            const file = e.dataTransfer.files[0];
                                            if (file && file.type.startsWith('image/')) {
                                                this.$refs.fileInput.files = e.dataTransfer.files;
                                                this.showPreview(file);
                                            }
                                        },
                                        handleSelect(e) {
                                            const file = e.target.files[0];
                                            if (file) this.showPreview(file);
                                        },
                                        showPreview(file) {
                                            const reader = new FileReader();
                                            reader.onload = (e) => this.preview = e.target.result;
                                            reader.readAsDataURL(file);
                                        }
                                    }"
                                    @dragover.prevent="isDragging = true"
                                    @dragleave.prevent="isDragging = false"
                                    @drop.prevent="handleDrop($event)"
                                    :class="isDragging ? 'border-yellow-400 bg-yellow-400/5' : 'border-gray-700 bg-black/20'"
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-3xl hover:border-yellow-400 transition-all cursor-pointer relative group"
                                    @click="$refs.fileInput.click()"
                                >
                                    <div class="space-y-1 text-center" x-show="!preview">
                                        <i class="fa-solid fa-cloud-arrow-up text-gray-600 text-5xl mb-4 group-hover:text-yellow-400 transition-colors"></i>
                                        <div class="flex text-sm text-gray-400">
                                            <span class="font-bold text-yellow-400">Upload a file</span>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, WEBP up to 2MB</p>
                                    </div>
                                    
                                    <!-- Preview Mode -->
                                    <div x-show="preview" class="w-full text-center" x-cloak>
                                        <img :src="preview" class="mx-auto h-48 w-full object-cover rounded-2xl mb-4 border border-gray-700 shadow-xl">
                                        <button type="button" @click.stop="preview = null; $refs.fileInput.value = ''" class="text-xs text-red-400 hover:text-red-300 font-bold uppercase tracking-widest">
                                            <i class="fa-solid fa-trash mr-1"></i> Remove & Change
                                        </button>
                                    </div>

                                    <input type="file" name="poster" x-ref="fileInput" @change="handleSelect($event)" class="sr-only" required accept="image/*">
                                </div>
                                @error('poster') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </section>

                    <div class="pt-10">
                        <button type="submit" class="w-full py-5 bg-yellow-400 hover:bg-yellow-300 text-black font-extrabold text-lg rounded-2xl shadow-2xl transition-all transform hover:-translate-y-1">
                            Submit Event for Review
                        </button>
                        <p class="text-center text-gray-500 text-sm mt-6">
                            "For event listing rules, refer to our <a href="{{ route('event-guidelines') }}" class="underline hover:text-yellow-400">Event Submission Guidelines</a>."
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
