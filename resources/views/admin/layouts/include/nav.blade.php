<div class="navbar bg-base-100">
    <div class="flex-1">
        <div class="px-4 normal-case text-2xl">Admin Panel</div>
        <ul class="flex gap-2">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="btn btn-ghost @if (request()->routeIs('dashboard')) font-bold @endif">Beranda</a>
            </li>
            <li>
                <a href="{{ route('maps.index') }}"
                    class="btn btn-ghost @if (request()->routeIs(['maps.index', 'maps.create'])) font-bold @endif">Maps</a>
            </li>
        </ul>
    </div>
    <div class="flex-none">
        <ul class="menu menu-horizontal px-1">
            <li>
                <details>
                    <summary>
                        {{ Auth::user()->name }}
                    </summary>
                    <ul class="p-2 bg-base-100">
                        <li><a href="{{ route('logout') }}" class="btn btn-error btn-sm">Keluar</a></li>

                    </ul>
                </details>
            </li>
        </ul>
    </div>
</div>
