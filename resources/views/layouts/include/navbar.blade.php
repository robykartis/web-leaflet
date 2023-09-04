<nav class="w-full ">
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
        <div
            class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden lg:block mt-2 lg:mt-0 bg-gray-100 md:bg-transparent z-20">
            @if (Route::has('login'))
            <ul class="list-reset lg:flex justify-end flex-1 items-center">
                @auth
                <li class="mr-3">
                    <a href="{{ url('/home') }}"
                        class="inline-block py-2 px-4 text-gray-900 font-bold no-underline">Home</a>
                </li>
                <!-- Tambahkan elemen peta di sini -->
                <li class="mr-3">
                    <div id="map" style="width: 200px; height: 200px;"></div>
                </li>
                @else
                <li class="mr-3">
                    <a href="{{ route('login') }}"
                        class="inline-block py-2 px-4 text-gray-900 font-bold no-underline">Log in</a>
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