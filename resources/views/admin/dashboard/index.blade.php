@extends('admin.layouts.app')
@section('title')
{{ $title }}
@endsection
@section('breadcrumbs')
{{ Breadcrumbs::render() }}
@endsection
@section('content')
<section>
    <div class="justify-center items-center ">
        <div class="flex flex-wrap">
            <div class="w-full md:w-1/2 xl:w-full p-3">
                <div class="bg-white rounded-lg  text-center shadow">
                    <div class="stat">
                        <div class="stat-title font-bold text-gray-900">Total Penanda</div>
                        <div class="stat-value">{{ $total }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--Divider-->
<hr class="border-b-2 border-gray-400 my-8 mx-4">

<section class="mb-20">
    <div class="flex flex-row flex-wrap flex-grow mt-2">
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="card w-full bg-base-100 shadow-xl  mb-11">
                <div class="card-body">

                    <div class="flex gap-6 mx-auto">
                        <form method="GET" action="{{ route('maps.index') }}">
                            <div class="mb-4">
                                <label for="perPage">Tampilkan Data:</label>
                                <select id="perPage" class="rounded-2xl focus:outline-none" name="perPage"
                                    onchange="this.form.submit()">
                                    <option value="5" {{ $perPage==5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ $perPage==10 ? 'selected' : '' }}>10</option>
                                    <option value="50" {{ $perPage==50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $perPage==100 ? 'selected' : '' }}>100</option>

                                </select>
                            </div>
                        </form>
                        <form method="GET" action="{{ route('maps.index') }}">
                            <div class="mb-4">
                                <label for="search">Cari Berdasarkan Penanda:</label>
                                <input class="rounded-2xl focus:outline-none" type="text"
                                    placeholder="Cari Berdasarkan Penanda" id="search" name="search"
                                    value="{{ $search }}">
                                <button class="btn btn-accent btn-sm" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Penanda</th>
                                    <th>Keterangan</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $currentPage = $maps->currentPage();
                                $index = ($currentPage - 1) * $maps->perPage() + 1;
                                @endphp

                                @forelse ($maps as $map)
                                <tr>
                                    <td class="font-bold">
                                        {{ $index++ }}
                                    </td>
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <div class="avatar">
                                                <div class="mask mask-squircle w-12 h-12">
                                                    @if ($map->image)
                                                    <img src="{{ asset('assets/image/mark/thumbnail/mark_' . $map->image) }}"
                                                        alt="Mark image" />
                                                    @else
                                                    <img src="{{ asset('assets/image/noimg.png') }}" alt="No Image" />
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold">{{ $map->title }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $map->description }}
                                    </td>
                                    <td>{{ $map->lat }}</td>
                                    <td>{{ $map->lng }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data yang tersedia.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $maps->links() }}
                    </div>

                </div>
            </div>
            <!--/table Card-->
        </div>
    </div>
</section>
@endsection