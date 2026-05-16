@extends('layouts.admin')

@section('page-title', 'Premium Hero Sliders')

@section('content')
    <div class="container px-3 py-6 mx-auto sm:px-4 sm:py-8">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-2xl font-black text-gray-800">Premium Hero Sliders</h1>
            <a href="{{ route('admin.hero-sliders.create') }}"
                class="px-6 py-2.5 text-white transition rounded-xl bg-blue-600 hover:bg-blue-700 font-bold text-center shadow-lg shadow-blue-200">
                Add New Slider
            </a>
        </div>

        <div class="overflow-hidden bg-white rounded-2xl shadow-sm border border-gray-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Preview</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Details</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Order</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 italic">
                    @forelse ($sliders as $slider)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="relative w-24 h-14 rounded-lg overflow-hidden border border-gray-100 shadow-sm">
                                    <img src="{{ asset('storage/' . $slider->display_image) }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Preview">
                                    <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <div class="font-black text-gray-800 line-clamp-1">{{ $slider->display_title ?? 'Untitled' }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[9px] font-black uppercase tracking-wider rounded border border-blue-100">
                                            {{ $slider->item_type }}
                                        </span>
                                        @if($slider->item_type === 'Manual')
                                            <div class="text-[10px] text-gray-400 font-bold truncate max-w-xs">{{ $slider->subtitle }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center font-black text-gray-400">
                                {{ $slider->sort_order ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($slider->is_active)
                                    <span class="px-3 py-1 text-[10px] font-black text-emerald-600 bg-emerald-50 rounded-full uppercase tracking-widest border border-emerald-100">Active</span>
                                @else
                                    <span class="px-3 py-1 text-[10px] font-black text-rose-600 bg-rose-50 rounded-full uppercase tracking-widest border border-rose-100">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ $slider->edit_url }}" title="Edit {{ $slider->item_type }}"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($slider->item_type === 'Manual')
                                        <form action="{{ route('admin.hero-sliders.destroy', $slider) }}" method="POST"
                                            onsubmit="return confirm('Delete this manual slider?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-all">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-gray-400 flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-sliders-h text-2xl text-gray-200"></i>
                                </div>
                                <p class="text-sm font-bold">No Premium Hero Sliders configured.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
