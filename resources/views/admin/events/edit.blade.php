@extends('layouts.admin')

@section('page-title', 'Edit Event - ' . $event->title)

@section('content')
<div class="container px-4 py-8 mx-auto">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.events.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-100 rounded-xl text-gray-400 hover:text-gray-900 shadow-sm transition-all">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-2xl font-black text-gray-800 tracking-tight uppercase">EDIT EVENT</h1>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Update event details and approval status</p>
        </div>
    </div>

    <div class="max-w-4xl">
        <div class="bg-white border border-gray-100 rounded-[2.5rem] p-8 md:p-12 shadow-sm">
            <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Status Section -->
                    <div class="md:col-span-2 p-6 bg-slate-50 rounded-[2rem] border border-slate-100">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Moderation Status</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach(['pending', 'approved', 'rejected'] as $status)
                                <label class="relative flex-1 min-w-[120px] cursor-pointer group">
                                    <input type="radio" name="approval_status" value="{{ $status }}" {{ $event->approval_status == $status ? 'checked' : '' }} class="peer sr-only">
                                    <div class="w-full py-4 text-center rounded-2xl border-2 border-transparent bg-white text-xs font-black uppercase tracking-widest transition-all
                                        peer-checked:border-blue-500 peer-checked:text-blue-600 peer-checked:shadow-lg peer-checked:shadow-blue-100
                                        group-hover:bg-gray-50 text-gray-400">
                                        {{ $status }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Details Section -->
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Event Title</label>
                        <input type="text" name="title" value="{{ old('title', $event->title) }}" required
                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Event Type</label>
                        <input type="text" name="event_type" value="{{ old('event_type', $event->event_type) }}" required
                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Event Mode</label>
                        <select name="event_mode" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                            <option value="Offline" {{ $event->event_mode == 'Offline' ? 'selected' : '' }}>Offline</option>
                            <option value="Online" {{ $event->event_mode == 'Online' ? 'selected' : '' }}>Online</option>
                            <option value="Hybrid" {{ $event->event_mode == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Event Date</label>
                        <input type="date" name="event_date" value="{{ old('event_date', $event->start_datetime->format('Y-m-d')) }}" required
                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Start</label>
                            <input type="time" name="start_time" value="{{ old('start_time', $event->start_datetime->format('H:i')) }}" required
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">End</label>
                            <input type="time" name="end_time" value="{{ old('end_time', $event->end_datetime->format('H:i')) }}" required
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Venue</label>
                        <input type="text" name="venue" value="{{ old('venue', $event->venue) }}" required
                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Organizer Name</label>
                        <input type="text" name="organizer_name" value="{{ old('organizer_name', $event->organizer_name) }}" required
                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Contact Email</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $event->contact_email) }}" required
                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Description</label>
                        <textarea name="description" rows="6" required
                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 focus:ring-2 focus:ring-blue-500 transition-all outline-none">{{ old('description', $event->description) }}</textarea>
                    </div>

                    <!-- Poster Section -->
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Event Poster</label>
                        <div x-data="{ isDragging: false, preview: null }"
                             @dragover.prevent="isDragging = true"
                             @dragleave.prevent="isDragging = false"
                             @drop.prevent="isDragging = false; const file = $event.dataTransfer.files[0]; if(file) { $refs.fileInput.files = $event.dataTransfer.files; const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"
                             :class="isDragging ? 'border-blue-500 bg-blue-50' : 'border-gray-100 bg-gray-50'"
                             class="relative p-8 border-2 border-dashed rounded-[2rem] text-center transition-all cursor-pointer group"
                             @click="$refs.fileInput.click()">
                            
                            <template x-if="!preview">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="relative w-48 h-28 shrink-0 overflow-hidden rounded-xl shadow-lg border border-white">
                                        <img src="{{ $event->poster_url }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i class="fas fa-camera text-white text-xl"></i>
                                        </div>
                                    </div>
                                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Click or drag to change poster</p>
                                </div>
                            </template>

                            <template x-if="preview">
                                <div class="flex flex-col items-center gap-4">
                                    <img :src="preview" class="w-48 h-28 object-cover rounded-xl shadow-2xl border-2 border-blue-500">
                                    <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest animate-pulse">New poster selected</p>
                                </div>
                            </template>

                            <input type="file" name="poster" x-ref="fileInput" class="sr-only" accept="image/*"
                                @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }">
                        </div>
                    </div>
                </div>

                <div class="pt-8">
                    <button type="submit" class="w-full py-5 bg-slate-900 hover:bg-black text-white font-black text-sm uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-slate-200 transition-all transform hover:-translate-y-1">
                        Update Event Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
