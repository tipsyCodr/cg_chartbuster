<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" :class="isDark ? 'dark' : 'light'" x-data="{ isDark: false }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="text-sm text-white font-montserrat" >  
    <div class="px-2 lg:px-20 bg-gradient-dark">
        <x-top-bar />
                {{ $slot }}
    </div>
    <x-notification-toast/>
    <section class="footer">
        <footer class="px-6 py-10 text-white bg-black md:px-16">
            <div class="flex flex-col items-start justify-between md:flex-row md:items-center">
                <!-- Brand Section -->
                <div class="flex flex-col gap-4 mb-6 md:mb-0">
                    <h1 class="text-2xl font-bold">CG Chartbusters</h1>
                    <img src="{{ asset('images/logo.png') }}" class="w-48" alt="CG Chartbusters Logo">
                    <p class="max-w-md text-sm leading-relaxed text-gray-400">
                        CG Chartbusters is your gateway to the vibrant world of Chollywood, celebrating the unique charm and cultural richness of Chhattisgarhi cinema. Discover movies, connect with stars, and dive into stories that matter.
                    </p>
                </div>
    
                <!-- Links Section -->
                <div class="flex flex-wrap md:space-x-16">
                    <!-- Quick Links -->
                    <div class="flex flex-col gap-2">
                        <h2 class="text-lg font-semibold">Quick Links</h2>
                        <a href="#" class="text-sm text-gray-400 hover:text-white">Home</a>
                        <a href="#" class="text-sm text-gray-400 hover:text-white">Movies</a>
                        <a href="#" class="text-sm text-gray-400 hover:text-white">Reviews</a>
                        <a href="#" class="text-sm text-gray-400 hover:text-white">Contact</a>
                    </div>
    
                    <!-- Social Media -->
                    <div class="flex flex-col gap-2">
                        <h2 class="text-lg font-semibold">Follow Us</h2>
                        <div class="flex space-x-4">
                            <a href="https://www.facebook.com/share/12KUPCYD8ud/" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white">
                                <i class="fab fa-facebook fa-xl"></i>
                            </a>
                            <a href="https://www.youtube.com/@CGchartbusters" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white">
                                <i class="fab fa-youtube fa-xl"></i>
                            </a>
                            {{-- <a href="https://twitter.com/cgchartbusters" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white">
                                <i class="fab fa-twitter fa-xl"></i>
                            </a> --}}
                            <a href="https://www.instagram.com/cgchartbusters?igsh=amF5cHJjaDdmcmJ1" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white">
                                <i class="fab fa-instagram fa-xl"></i>
                            </a>
                            {{-- <a href="https://www.linkedin.com/company/cgchartbusters/" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white">
                                <i class="fab fa-linkedin fa-xl"></i>
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Divider -->
            <div class="mt-8 border-t border-gray-700"></div>
    
            <!-- Copyright Section -->
            <div class="py-4 text-center">
                <p class="text-sm text-gray-400">&copy; {{ date('Y') }} CG Chartbusters. All rights reserved.</p>
            </div>
        </footer>
    </section>
    

</body>

</html>
