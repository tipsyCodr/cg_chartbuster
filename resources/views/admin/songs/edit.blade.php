@extends('layouts.admin')

@section('content')
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Song') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Edit Song
                    </h3>
                </div>
                <div class="px-4 py-5 overflow-hidden bg-white shadow sm:rounded-md mt-50 sm:p-6">
                    <form method="POST" action="{{ route('admin.songs.update', $songs) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="">
                            <div class="mb-4 ">


                                <div>
                                    <label for="title" class="block my-1 text-sm font-medium text-gray-700">Song
                                        Title</label>
                                    <input type="text" name="title" id="title" required value="{{ $songs->title }}"
                                        class="mt-1 block w-full rounded-md @error('title') is-invalid @enderror border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @error('title')
                                        @foreach ($errors->get('title') as $message)
                                            <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}
                                            </div>
                                        @endforeach
                                    @enderror
                                </div>

                                <div>
                                    <label for="description"
                                        class="block my-1 text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="description" rows="3"
                                        class="mt-1 block w-full @error('description') is-invalid @enderror rounded-md  border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                      {{ $songs->description }}
                                    </textarea>
                                    @error('description')
                                        @foreach ($errors->get('description') as $message)
                                            <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}
                                            </div>
                                        @endforeach
                                    @enderror
                                </div>
                                <div>
                                    <label for="release_date" class="block my-1 text-sm font-medium text-gray-700">Release
                                        Date</label>
                                    <input type="date" name="release_date" id="release_date" value="{{ $songs->release_date }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                    @error('release_date')
                                        @foreach ($errors->get('release_date') as $message)
                                            <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}
                                            </div>
                                        @endforeach
                                    @enderror
                                </div>

                                <div>
                                    <label for="genre" class="block my-1 text-sm font-medium text-gray-700">Genre</label>
                                    <input type="text" name="genre" id="genre"  value="{{ $songs->genre }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                    @error('genre')
                                        @foreach ($errors->get('genre') as $message)
                                            <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}
                                            </div>
                                        @endforeach
                                    @enderror
                                </div>
                                <div x-data="{ hours: 0, minutes: 0 }">
                                    <input type="hidden" name="duration" id="duration"  value="{{ $songs->duration }}"
                                        :value="`${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`" 
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                    
                                    <label class="block my-1 text-sm font-medium text-gray-700">Duration</label>
                                    <div class="flex items-center space-x-2">
                                        <div>
                                            <label for="movie-duration-hour" class="block my-1 text-sm font-medium text-gray-700">Hour</label>
                                            <input type="number" placeholder="HH" id="movie-duration-hour" name="movie_duration_hour" 
                                                x-model.number="hours" min="0" step="1" class="w-20 p-2 my-2 border border-gray-300 rounded">
                                        </div>
                                        <span class="pt-5 mx-2">:</span>
                                        <div>
                                            <label for="movie-duration-minute" class="block my-1 text-sm font-medium text-gray-700">Minute</label>
                                            <input type="number" placeholder="MM" id="movie-duration-minute" name="movie_duration_minute" 
                                                x-model.number="minutes" min="0" max="59" step="1" class="w-full p-2 my-2 border border-gray-300 rounded">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="director"
                                        class="block my-1 text-sm font-medium text-gray-700">Director</label>
                                    <input type="text" name="director" id="director"  value="{{ $songs->director }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                    @error('director')
                                        @foreach ($errors->get('director') as $message)
                                            <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}
                                            </div>
                                        @endforeach
                                    @enderror
                                </div>

                                <div>
                                    <label for="region"
                                        class="block my-1 text-sm font-medium text-gray-700">Region</label>
                                    <input type="text" name="region" id="region" value="{{ $songs->region }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                {{-- <div>
                                    <label for="cbfc"
                                        class="block my-1 text-sm font-medium text-gray-700">CBFC</label>
                                    <input type="text" name="cbfc" id="cbfc"  value="{{ $songs->cbfc }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div> --}}

                                {{-- for future reference --}}
                                {{-- <div>
                                <label for="cg_chartbusters_ratings" class="block my-1 text-sm font-medium text-gray-700">CG Chartbusters Ratings</label>
                                <input type="number" name="cg_chartbusters_ratings" id="cg_chartbusters_ratings"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div>

                            <div>
                                <label for="imdb_ratings" class="block my-1 text-sm font-medium text-gray-700">IMDB Ratings</label>
                                <input type="number" name="imdb_ratings" id="imdb_ratings"
                                    class="w-full p-2 my-2 border border-gray-300 rounded">
                            </div> --}}

{{--            
                                <div>
                                    <label for="dop" class="block my-1 text-sm font-medium text-gray-700">DOP</label>
                                    <input type="text" name="dop" id="dop"  value="{{ $songs->dop }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>


                                <div>
                                    <label for="male_lead" class="block my-1 text-sm font-medium text-gray-700">Male
                                        Lead</label>
                                    <input type="text" name="male_lead" id="male_lead" value="{{ $songs->male_lead }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="female_lead" class="block my-1 text-sm font-medium text-gray-700">Female
                                        Lead</label>
                                    <input type="text" name="female_lead" id="female_lead" value="{{ $songs->female_lead }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div> --}}

                                <div>
                                    <label for="support_artists"
                                        class="block my-1 text-sm font-medium text-gray-700">Support Artists</label>
                                    <input type="text" name="support_artists" id="support_artists" value="{{ $songs->support_artists }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>



                                <div>
                                    <label for="producer"
                                        class="block my-1 text-sm font-medium text-gray-700">Producer</label>
                                    <input type="text" name="producer" id="producer" value="{{ $songs->producer }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="singer_male" class="block my-1 text-sm font-medium text-gray-700">Singer
                                        Male</label>
                                    <input type="text" name="singer_male" id="singer_male" value="{{ $songs->singer_male }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="singer_female" class="block my-1 text-sm font-medium text-gray-700">Singer
                                        Female</label>
                                    <input type="text" name="singer_female" id="singer_female" value="{{ $songs->singer_female }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                             
                                <div>
                                    <label for="composition"
                                        class="block my-1 text-sm font-medium text-gray-700">Composition</label>
                                    <input type="text" name="composition" id="composition" value="{{ $songs->composition }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="mix_master" class="block my-1 text-sm font-medium text-gray-700">Mix
                                        Master</label>
                                    <input type="text" name="mix_master" id="mix_master"  value="{{ $songs->mix_master }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="music"
                                        class="block my-1 text-sm font-medium text-gray-700">Music</label>
                                    <input type="text" name="music" id="music" value="{{ $songs->music }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="recordists"
                                        class="block my-1 text-sm font-medium text-gray-700">Recordists</label>
                                    <input type="text" name="recordists" id="recordists" value="{{ $songs->recordists }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="audio_studio" class="block my-1 text-sm font-medium text-gray-700">Audio
                                        Studio</label>
                                    <input type="text" name="audio_studio" id="audio_studio"  value="{{ $songs->audio_studio }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>
                                <div>
                                    <label for="editor"
                                        class="block my-1 text-sm font-medium text-gray-700">Editor</label>
                                    <input type="text" name="editor" id="editor" value="{{ $songs->editor }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                    

                                
                                    <div>
                                        <label for="make_up" class="block my-1 text-sm font-medium text-gray-700">Make
                                            Up</label>
                                        <input type="text" name="make_up" id="make_up" value="{{ $songs->make_up }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>

                                   

                                    <div>
                                        <label for="others"
                                            class="block my-1 text-sm font-medium text-gray-700">Others</label>
                                        <input type="text" name="others" id="others"  value="{{ $songs->others }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>

                                    <div>
                                        <label for="content_description"
                                            class="block my-1 text-sm font-medium text-gray-700">Content
                                            Description</label>
                                        <textarea name="content_description" id="content_description" rows="3"
                                            class="w-full p-2 my-2 border border-gray-300 rounded"> {{ $songs->content_description }}</textarea>
                                    </div>
                                   
                                    {{-- <div>
                                        <label for="hyperlinks_links"
                                            class="block my-1 text-sm font-medium text-gray-700">Hyperlinks Links</label>
                                        <input type="text" name="hyperlinks_links" id="hyperlinks_links"  value="{{ $songs->hyperlinks_links }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div> --}}
                                    {{-- <div>
                                        <label for="poster_logo"
                                            class="block my-1 text-sm font-medium text-gray-700">Poster Logo</label>
                                        <input type="file" name="poster_logo" id="poster_logo"  value="{{ $songs->poster_logo }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div> --}}
                                    <div>
                                        <label for="poster_image"
                                            class="block my-1 text-sm font-medium text-gray-700">Poster Image</label>
                                        <input type="file" name="poster_image" id="poster_image" accept="image/*"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                        @error('poster_image')
                                            @foreach ($errors->get('poster_image') as $message)
                                                <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">
                                                    {{ $message }}</div>
                                            @endforeach
                                        @enderror
                                    </div>
                                    
                                    {{-- <div>
                                        <label for="production_banner"
                                            class="block my-1 text-sm font-medium text-gray-700">Production Banner</label>
                                        <input type="file" name="production_banner" id="production_banner"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>
                                    <div>
                                        <label for="poster_image_landscape"
                                            class="block my-1 text-sm font-medium text-gray-700">Poster Image
                                            Landscape</label>
                                        <input type="file" name="poster_image_landscape" id="poster_image_landscape"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                            <button type="submit"
                                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
