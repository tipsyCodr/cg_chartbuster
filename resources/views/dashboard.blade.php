
<x-app-layout :movies="$movies" :artists="$artists" >
    <!-- This will be similiar UI but have ligged in user's contents. -->
    <h1 class="text-xl font-bold mb-4">Welcome, {{ auth()->user()->name }}!</h1>
    
    <x-movies :movies="$movies" :artists="$artists" />
    <x-albums :movies="$movies" :artists="$artists" />
    <x-artists :movies="$movies" :artists="$artists" />


</x-app-layout>
