<x-app-layout :movies="$movies" :artists="$artists" >
    <x-movies :movies="$movies" :artists="$artists"/>
    <x-albums :artists="$artists" :movies="$movies" />
    <x-artists :artists="$artists" :movies="$movies" />
</x-app-layout>