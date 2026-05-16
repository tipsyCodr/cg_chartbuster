@extends('layouts.admin')

@section('page-title', 'Edit Premium Hero Slider')

@section('content')
    <div class="container px-3 py-6 mx-auto sm:px-4 sm:py-8 max-w-4xl">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-black text-gray-800">Edit Premium Hero Slider</h1>
            <a href="{{ route('admin.hero-sliders.index') }}" class="text-blue-600 hover:underline font-bold text-sm flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to List
            </a>
        </div>

        @if ($errors->any())
            <div class="p-4 mb-6 text-rose-700 bg-rose-50 border border-rose-100 rounded-2xl italic font-medium">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-10">
            <form action="{{ route('admin.hero-sliders.update', $heroSlider) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2">
                        <label class="block mb-4 text-xs font-black text-gray-400 uppercase tracking-widest">Current Background</label>
                        <div class="relative group w-full h-48 rounded-2xl overflow-hidden border border-gray-100 mb-4">
                            <img src="{{ asset('storage/' . $heroSlider->image) }}" class="w-full h-full object-cover" alt="Preview">
                        </div>
                        
                        <label for="image" class="block mb-2 text-xs font-black text-gray-400 uppercase tracking-widest">Replace Background Image</label>
                        <div class="relative group">
                            <input type="file" name="image" id="image" accept="image/*"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all border border-dashed border-gray-200 rounded-2xl p-4 bg-gray-50/50">
                        </div>
                        <p class="mt-2 text-[10px] text-gray-400 font-bold italic uppercase tracking-wider">Leave empty to keep existing image. Max size: 5MB.</p>
                    </div>

                    <div>
                        <label for="title" class="block mb-2 text-xs font-black text-gray-400 uppercase tracking-widest">Hero Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $heroSlider->title) }}"
                            placeholder="e.g. Latest Blockbuster Movie"
                            class="block w-full rounded-xl border-gray-100 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-0 transition-all font-bold">
                    </div>

                    <div>
                        <label for="subtitle" class="block mb-2 text-xs font-black text-gray-400 uppercase tracking-widest">Hero Subtitle</label>
                        <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $heroSlider->subtitle) }}"
                            placeholder="e.g. Now Streaming exclusively on our platform"
                            class="block w-full rounded-xl border-gray-100 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-0 transition-all font-bold">
                    </div>

                    <div>
                        <label for="button_text" class="block mb-2 text-xs font-black text-gray-400 uppercase tracking-widest">CTA Button Label</label>
                        <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $heroSlider->button_text) }}"
                            placeholder="e.g. Watch Now"
                            class="block w-full rounded-xl border-gray-100 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-0 transition-all font-bold">
                    </div>

                    <div>
                        <label for="button_link" class="block mb-2 text-xs font-black text-gray-400 uppercase tracking-widest">CTA Button Link</label>
                        <input type="text" name="button_link" id="button_link" value="{{ old('button_link', $heroSlider->button_link) }}"
                            placeholder="e.g. /movie/slug"
                            class="block w-full rounded-xl border-gray-100 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-0 transition-all font-bold">
                    </div>

                    <div>
                        <label for="sort_order" class="block mb-2 text-xs font-black text-gray-400 uppercase tracking-widest">Display Sequence</label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $heroSlider->sort_order) }}"
                            class="block w-full rounded-xl border-gray-100 bg-gray-50/50 text-sm p-3 focus:border-blue-500 focus:ring-0 transition-all font-bold">
                    </div>

                    <div class="flex items-center gap-3 pt-6">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ $heroSlider->is_active ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-gray-200 rounded-lg focus:ring-0 transition-all">
                        <label for="is_active" class="text-xs font-black text-gray-800 uppercase tracking-widest italic cursor-pointer">Published Status</label>
                    </div>
                </div>

                <div class="pt-8 border-t border-gray-50 flex justify-end gap-4">
                    <a href="{{ route('admin.hero-sliders.index') }}"
                        class="px-8 py-3 text-xs font-black text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-colors">
                        Discard
                    </a>
                    <button type="submit"
                        class="px-12 py-3 text-xs font-black text-white uppercase tracking-widest rounded-xl shadow-xl shadow-blue-100 bg-blue-600 hover:bg-blue-700 transition-all transform active:scale-95">
                        Update Slider
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
