<div class="navbar bg-base-100 border-b shadow">
    <div class="flex-1">
        <a href="/" class="pl-4 normal-case text-xl">Maps</a>
    </div>
    <div class="flex-none">
        @if (Route::has('login'))
        <ul class="menu menu-horizontal px-1">
            @auth
            <li><a class="btn btn-outline btn-accent btn-sm" href="{{ route('dashboard') }}">Beranda</a></li>
            @else
            <li><a class="btn btn-outline btn-accent btn-sm" href="{{ route('login') }}">Login</a></li>

            @endauth
        </ul>
        @endif
    </div>
</div>