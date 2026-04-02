@extends('layouts.admin')

@section('page-title', 'Song Management')

@section('content')
<div class="container px-4 py-8 mx-auto">
    <div class="mb-8 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-black text-gray-800 tracking-tight uppercase">SONG LIBRARY</h1>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Manage tracks, lyrics and credits</p>
        </div>
        
        <div class="flex items-center gap-3">
             <div class="flex items-center gap-2 px-4 py-2 bg-blue-50 rounded-xl border border-blue-100">
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Library Live</span>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 px-5 py-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-200 animate-bounce">
                <i class="fas fa-check text-xs"></i>
            </div>
            <p class="text-sm font-bold text-emerald-600 uppercase tracking-wide">{{ session('success') }}</p>
        </div>
    @endif

    <div class="space-y-6">
        <livewire:dynamic-search 
            model="Song" 
            :columns="['poster_image', 'title', 'album', 'release_date']" 
        />
    </div>
</div>
@endsection
