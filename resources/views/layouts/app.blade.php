<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" :class="isDark ? 'dark' : 'light'"
    x-data="{ isDark: false }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <title>@yield('meta_title', config('app.name'))</title>
    <meta name="title" content="@yield('meta_title', config('app.name'))">
    <meta name="description" content="@yield('meta_description', 'CG Chartbusters is your gateway to the vibrant world of Chollywood.')">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('meta_title', config('app.name'))">
    <meta property="og:description" content="@yield('meta_description', 'CG Chartbusters is your gateway to the vibrant world of Chollywood.')">
    <meta property="og:image" content="@yield('meta_image', asset('images/logo.png'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('meta_title', config('app.name'))">
    <meta property="twitter:description" content="@yield('meta_description', 'CG Chartbusters is your gateway to the vibrant world of Chollywood.')">
    <meta property="twitter:image" content="@yield('meta_image', asset('images/logo.png'))">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    @if(config('services.google_analytics.id'))
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics.id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('services.google_analytics.id') }}');
        </script>
    @endif

    <style>
        /* Google Translate Toolbar Fixing */
        .goog-te-banner-frame.skiptranslate {
            display: none !important;
        }

        body {
            top: 0px !important;
        }

        /* Customize Gadget (Simple Layout) */
        #google_translate_element .goog-te-gadget-simple {
            background-color: #111827 !important; /* gray-900 */
            border: 1px solid #374151 !important; /* gray-700 */
            padding: 4px 10px !important;
            border-radius: 9999px !important;
            display: inline-flex !important;
            align-items: center !important;
            height: 38px !important;
            gap: 4px !important;
            color: #D1D5DB !important; /* gray-300 */
            font-size: 13px !important;
        }

        /* Hide Google Logo & Text */
        #google_translate_element .goog-te-gadget-simple img,
        #google_translate_element .goog-te-gadget-simple .goog-te-menu-value span[style*="color: rgb(118, 118, 118)"],
        #google_translate_element .goog-te-gadget-simple .goog-te-menu-value span[style*="color: rgb(128, 128, 128)"] {
            display: none !important;
        }

        #google_translate_element .goog-te-gadget-simple .goog-te-menu-value {
            display: flex !important;
            align-items: center !important;
            margin: 0 !important;
            color: #D1D5DB !important;
        }

        #google_translate_element .goog-te-gadget-simple .goog-te-menu-value span {
            border: none !important;
            color: #D1D5DB !important;
            font-weight: 600 !important;
        }
        
        #google_translate_element .goog-te-gadget-simple .goog-te-menu-value:after {
            content: "\f0d7"; /* chevron down */
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            margin-left: 6px;
            color: #fbbf24; /* yellow-400 */
        }
    </style>

</head>

<body class="overflow-x-hidden text-sm text-white font-montserrat bg-black">
    <div class="px-2 lg:px-20 bg-gradient-dark">
        <x-top-bar />
        {{ $slot }}
    </div>
    <x-notification-toast />
    <section class="footer">
        <footer class="px-6 py-10 text-white bg-black md:px-16">
            <div class="flex flex-col items-start justify-between md:flex-row md:items-center">
                <!-- Brand Section -->
                <div class="flex flex-col gap-4 mb-6 md:mb-0">
                    <h1 class="text-2xl font-bold">CG Chartbusters</h1>
                    <img src="{{ asset('images/logo.png') }}" class="w-48" alt="CG Chartbusters Logo">
                    <p class="max-w-md text-sm leading-relaxed text-gray-400">
                        CG Chartbusters is your gateway to the vibrant world of Chollywood, celebrating the unique charm
                        and cultural richness of Chhattisgarhi cinema. Discover movies, connect with stars, and dive
                        into stories that matter.
                    </p>
                </div>

                <!-- Links Section -->
                <div class="flex flex-wrap md:space-x-16">
                    <!-- Quick Links -->
                    <div class="flex flex-col gap-2">
                        <h2 class="text-lg font-semibold">Quick Links</h2>
                        
                        <a href="{{ route('home') }}" class="font-medium text-gray-300 hover:text-yellow-300 transition-colors">Home</a>
                        <a href="{{ route('about-us') }}" class="font-medium text-gray-300 hover:text-yellow-300 transition-colors">About Us</a>
                        <a href="{{ route('movies') }}"
                            class="font-medium text-gray-300 hover:text-yellow-300 transition-colors">Movies</a>
                        <a href="{{ route('tv-shows') }}" class="font-medium text-gray-300 hover:text-yellow-300 transition-colors">TV
                            Shows</a>
                        <a href="{{ route('songs') }}" class="font-medium text-gray-300 hover:text-yellow-300 transition-colors">Songs</a>
                        <a href="{{ route('artists') }}"
                            class="font-medium text-gray-300 hover:text-yellow-300 transition-colors">Artist</a>
                        <a href="{{ route('articles.index') }}"
                            class="font-medium text-gray-300 hover:text-yellow-300 transition-colors">Articles</a>
                    </div>

                    <!-- Legal Links -->
                    <div class="flex flex-col gap-2">
                        <h2 class="text-lg font-semibold">Legal</h2>
                        <a href="{{ route('terms-and-conditions') }}" class="font-medium text-gray-300 hover:text-yellow-300 transition-colors">Terms & Conditions</a>
                        <a href="{{ route('privacy-policy') }}" class="font-medium text-gray-300 hover:text-yellow-300 transition-colors">Privacy Policy</a>
                        <a href="{{ route('copyright-policy') }}" class="font-medium text-gray-300 hover:text-yellow-300 transition-colors">Copyright & Takedown Policy</a>
                        <a href="{{ route('community-guidelines') }}" class="font-medium text-gray-300 hover:text-yellow-300 transition-colors">Community Guidelines</a>
                        <a href="{{ route('content-moderation-policy') }}" class="font-medium text-gray-300 hover:text-yellow-300 transition-colors">Content Moderation Policy</a>
                        <a href="{{ route('disclaimer') }}" class="font-medium text-gray-300 hover:text-yellow-300 transition-colors">Disclaimer</a>
                    </div>

                    <!-- Social Media -->
                    <div class="flex flex-col gap-2">
                        <h2 class="text-lg font-semibold">Follow Us</h2>
                        <div class="flex space-x-4">
                            <a href="https://www.facebook.com/share/12KUPCYD8ud/" target="_blank"
                                rel="noopener noreferrer" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-facebook fa-xl"></i>
                            </a>
                            <a href="https://x.com/cgchartbusters" target="_blank" rel="noopener noreferrer"
                                class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-x-twitter fa-xl"></i>
                            </a>
                            <a href="https://www.youtube.com/@CGchartbusters" target="_blank" rel="noopener noreferrer"
                                class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-youtube fa-xl"></i>
                            </a>
                            <a href="https://www.instagram.com/cgchartbusters?igsh=amF5cHJjaDdmcmJ1" target="_blank"
                                rel="noopener noreferrer" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-instagram fa-xl"></i>
                            </a>
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


    @livewireScripts
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'hi,en,chh',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>

</html>
