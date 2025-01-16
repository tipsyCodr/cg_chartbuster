@extends('layouts.admin')

@section('content')
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Movie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Edit TV Show
                    </h3>
                </div>
                <div class="px-4 py-5 overflow-hidden bg-white shadow sm:rounded-md mt-50 sm:p-6">
                    <form method="POST" action="{{ route('admin.tvshows.update', $tvshows) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="">
                            <div class="mb-4 ">


                                <div>
                                    <label for="title" class="block my-1 text-sm font-medium text-gray-700">Show Title</label>
                                    <input type="text" name="title" id="title" required value="{{ $tvshows->title }}"
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
                                      {{ $tvshows->description }}
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
                                    <input type="date" name="release_date" id="release_date" value="{{ $tvshows->release_date }}"
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
                                    <input type="text" name="genre" id="genre"  value="{{ $tvshows->genre }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                    @error('genre')
                                        @foreach ($errors->get('genre') as $message)
                                            <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}
                                            </div>
                                        @endforeach
                                    @enderror
                                </div>
                                <div x-data="{ hours: 0, minutes: 0 }">
                                    <input type="hidden" name="duration" id="duration"  value="{{ $tvshows->duration }}"
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
                                    <input type="text" name="director" id="director"  value="{{ $tvshows->director }}"
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
                                    <input type="text" name="region" id="region" value="{{ $tvshows->region }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="cbfc"
                                        class="block my-1 text-sm font-medium text-gray-700">CBFC</label>
                                    <input type="text" name="cbfc" id="cbfc"  value="{{ $tvshows->cbfc }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

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

                                <div>
                                    <label for="cinematographer"
                                        class="block my-1 text-sm font-medium text-gray-700">Cinematographer</label>
                                    <input type="text" name="cinematographer" id="cinematographer"  value="{{ $tvshows->cinematographer }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="dop" class="block my-1 text-sm font-medium text-gray-700">DOP</label>
                                    <input type="text" name="dop" id="dop"  value="{{ $tvshows->dop }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="screen_play" class="block my-1 text-sm font-medium text-gray-700">Screen
                                        Play</label>
                                    <input type="text" name="screen_play" id="screen_play" value="{{ $tvshows->screen_play }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="writer_story_concept"
                                        class="block my-1 text-sm font-medium text-gray-700">Writer Story Concept</label>
                                    <textarea name="writer_story_concept" id="writer_story_concept" rows="3"  value=""
                                        class="w-full p-2 my-2 border border-gray-300 rounded">{{ $tvshows->writer_story_concept }}</textarea>
                                </div>

                                <div>
                                    <label for="male_lead" class="block my-1 text-sm font-medium text-gray-700">Male
                                        Lead</label>
                                    <input type="text" name="male_lead" id="male_lead" value="{{ $tvshows->male_lead }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="female_lead" class="block my-1 text-sm font-medium text-gray-700">Female
                                        Lead</label>
                                    <input type="text" name="female_lead" id="female_lead" value="{{ $tvshows->female_lead }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="support_artists"
                                        class="block my-1 text-sm font-medium text-gray-700">Support Artists</label>
                                    <input type="text" name="support_artists" id="support_artists" value="{{ $tvshows->support_artists }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>



                                <div>
                                    <label for="producer"
                                        class="block my-1 text-sm font-medium text-gray-700">Producer</label>
                                    <input type="text" name="producer" id="producer" value="{{ $tvshows->producer }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="songs"
                                        class="block my-1 text-sm font-medium text-gray-700">Songs</label>
                                    <input type="text" name="songs" id="songs" value="{{ $tvshows->songs }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="singer_male" class="block my-1 text-sm font-medium text-gray-700">Singer
                                        Male</label>
                                    <input type="text" name="singer_male" id="singer_male" value="{{ $tvshows->singer_male }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="singer_female" class="block my-1 text-sm font-medium text-gray-700">Singer
                                        Female</label>
                                    <input type="text" name="singer_female" id="singer_female" value="{{ $tvshows->singer_female }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="lyrics"
                                        class="block my-1 text-sm font-medium text-gray-700">Lyrics</label>
                                    <input type="text" name="lyrics" id="lyrics" value="{{ $tvshows->lyrics }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="composition"
                                        class="block my-1 text-sm font-medium text-gray-700">Composition</label>
                                    <input type="text" name="composition" id="composition" value="{{ $tvshows->composition }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="mix_master" class="block my-1 text-sm font-medium text-gray-700">Mix
                                        Master</label>
                                    <input type="text" name="mix_master" id="mix_master"  value="{{ $tvshows->mix_master }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="music"
                                        class="block my-1 text-sm font-medium text-gray-700">Music</label>
                                    <input type="text" name="music" id="music" value="{{ $tvshows->music }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="recordists"
                                        class="block my-1 text-sm font-medium text-gray-700">Recordists</label>
                                    <input type="text" name="recordists" id="recordists" value="{{ $tvshows->recordists }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>

                                <div>
                                    <label for="audio_studio" class="block my-1 text-sm font-medium text-gray-700">Audio
                                        Studio</label>
                                    <input type="text" name="audio_studio" id="audio_studio"  value="{{ $tvshows->audio_studio }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                </div>
                                <div>
                                    <label for="editor"
                                        class="block my-1 text-sm font-medium text-gray-700">Editor</label>
                                    <input type="text" name="editor" id="editor" value="{{ $tvshows->editor }}"
                                        class="w-full p-2 my-2 border border-gray-300 rounded">
                                    <div>
                                        <label for="video_studio"
                                            class="block my-1 text-sm font-medium text-gray-700">Video Studio</label>
                                        <input type="text" name="video_studio" id="video_studio" value="{{ $tvshows->video_studio }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>

                                    <div>
                                        <label for="vfx"
                                            class="block my-1 text-sm font-medium text-gray-700">VFX</label>
                                        <input type="text" name="vfx" id="vfx"  value="{{ $tvshows->vfx }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>

                                    <div>
                                        <label for="make_up" class="block my-1 text-sm font-medium text-gray-700">Make
                                            Up</label>
                                        <input type="text" name="make_up" id="make_up" value="{{ $tvshows->make_up }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>

                                    <div>
                                        <label for="drone"
                                            class="block my-1 text-sm font-medium text-gray-700">Drone</label>
                                        <input type="text" name="drone" id="drone" value="{{ $tvshows->drone }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>

                                    <div>
                                        <label for="others"
                                            class="block my-1 text-sm font-medium text-gray-700">Others</label>
                                        <input type="text" name="others" id="others"  value="{{ $tvshows->others }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>

                                    <div>
                                        <label for="content_description"
                                            class="block my-1 text-sm font-medium text-gray-700">Content
                                            Description</label>
                                        <textarea name="content_description" id="content_description" rows="3"
                                            class="w-full p-2 my-2 border border-gray-300 rounded"> {{ $tvshows->content_description }}</textarea>
                                    </div>
                                    <div>
                                        <label for="trailer_url"
                                            class="block my-1 text-sm font-medium text-gray-700">Trailer URL</label>
                                        <input type="url" name="trailer_url" id="trailer_url"  value="{{ $tvshows->trailer_url }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                        @error('trailer_url')
                                            @foreach ($errors->get('trailer_url') as $message)
                                                <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">
                                                    {{ $message }}</div>
                                            @endforeach
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="hyperlinks_links"
                                            class="block my-1 text-sm font-medium text-gray-700">Hyperlinks Links</label>
                                        <input type="text" name="hyperlinks_links" id="hyperlinks_links"  value="{{ $tvshows->hyperlinks_links }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>
                                    <div>
                                        <label for="poster_logo"
                                            class="block my-1 text-sm font-medium text-gray-700">Poster Logo</label>
                                        <input type="file" name="poster_logo" id="poster_logo"  value="{{ $tvshows->poster_logo }}"
                                            class="w-full p-2 my-2 border border-gray-300 rounded">
                                    </div>
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
                                    
                                    <div>
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
                                    </div>
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
