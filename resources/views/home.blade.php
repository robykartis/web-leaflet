<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Tailwind Starter Template - Minimal Blog: Tailwind Toolbox</title>
    <meta name="author" content="name" />
    <meta name="description" content="description here" />
    <meta name="keywords" content="keywords,here" />
    {{--
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" /> --}}
    <!--Replace with your tailwind.css once created-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-gray-100 font-sans">

    <nav id="header" class="w-full">
        <div class="w-full md:max-w-6xl mx-auto flex flex-wrap items-center justify-between mt-0 py-3">
            <div class="pl-4">
                <a class="text-gray-900 text-base no-underline hover:no-underline font-extrabold text-xl" href="#">
                    Maps
                </a>
            </div>
            <div class="block lg:hidden pr-4">
                <button id="nav-toggle"
                    class="flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-gray-900 hover:border-green-500 appearance-none focus:outline-none">
                    <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                    </svg>
                </button>
            </div>

            <div class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden lg:block mt-2 lg:mt-0 bg-gray-100 md:bg-transparent z-20"
                id="nav-content">

                @if (Route::has('login'))
                <ul class="list-reset lg:flex justify-end flex-1 items-center">
                    @auth
                    <li class="mr-3">
                        <a href="{{ url('/dashboard') }}"
                            class="inline-block py-2 px-4 text-gray-900 font-bold no-underline">Dashboard</a>
                    </li>
                    @else
                    <li class="mr-3">
                        <a href="{{ route('login') }}"
                            class="inline-block py-2 px-4 text-gray-900 font-bold no-underline">Log
                            in</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="mr-3">
                        <a href="{{ route('register') }}"
                            class="inline-block py-2 px-4 text-gray-900 font-bold no-underline">Register</a>
                    </li>
                    @endif
                    @endauth
                </ul>
                @endif
            </div>
        </div>
    </nav>

    <!--Container-->
    <div id="content" class="container w-full-xl md:max-w-6xl mx-auto pt-4 pb-10">
        @livewire('maps')
    </div>
    <!--/container-->
    @stack('js')
    <script>
        //Javascript to toggle the menu
		document.getElementById('nav-toggle').onclick = function() {
			document.getElementById("nav-content").classList.toggle("hidden");
		}
    </script>
</body>

</html>