@extends('admin.layouts.app')
@section('title')
{{ $title }}
@endsection

@section('breadcrumbs')
{{ Breadcrumbs::render() }}
@endsection
@section('content')
@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css" />
@endpush
<section>
    <div class="flex flex-row flex-wrap flex-grow p-2">
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="card w-full bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex justify-between items-center">
                        <h2 class="card-title"> Maps</h2>
                    </div>
                    <div id="map" class="rounded-lg" style="width: 100%; height: 450px;"></div>
                </div>
            </div>
            <!--/table Card-->
        </div>
    </div>
</section>
<section>
    <div class="flex flex-row flex-wrap flex-grow p-2">
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="card w-full bg-base-100 shadow-xl  mb-11">
                <div class="card-body">
                    <div class="flex justify-between items-center">
                        <h2 class="card-title">Data Maps</h2>
                        <a href="{{ route('maps.create') }}" class="ml-auto btn btn-accent btn-sm">Add Mark</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>Mark</th>
                                    <th>Description</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($maps as $map)
                                <tr>
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <div class="avatar">
                                                <div class="mask mask-squircle w-12 h-12">
                                                    <img src="{{asset('assets/image/mark/thumbnail/mark_'.$map->image) }}"
                                                        alt="Mark image" />
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold">{{$map->title}}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{$map->description}}
                                    </td>
                                    <td>{{$map->lat}}</td>
                                    <td>{{$map->lng}}</td>
                                    <th>
                                        <div class="flex gap-2">
                                            <button class="btn btn-outline btn-info btn-xs">details</button>
                                            <button class="btn btn-outline btn-warning btn-xs">edit</button>
                                            <button class="btn btn-outline btn-error btn-xs">delete</button>
                                        </div>
                                    </th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/table Card-->
        </div>
    </div>
</section>

@endsection
@push('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src='https://unpkg.com/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.js'></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet-search@3.0.9/dist/leaflet-search.src.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet.fullscreen@2.4.0/Control.FullScreen.min.js"></script>

<script>
    let map, markers = [];
    /* ----------------------------- Initialize Map ----------------------------- */
    function initMap() {
        map = L.map('map', {
            center: {
                lat: 0.4888556,
                lng: 101.4548226,
            },
            zoom: 10
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        map.on('click', mapClicked);
        fetchMapData().then(data => {
            initMarkers(data);
        });
    }
    initMap();

    /* --------------------------- Initialize Markers --------------------------- */
    function initMarkers(data) {
        for (let index = 0; index < data.length; index++) {
            const markerData = data[index];
            const marker = generateMarker(markerData, index);
            marker.addTo(map).bindPopup(`
            <figure class="px-0 pt-0">
                    <img src="assets/image/mark/thumbnail/mark_${markerData.position.image}" alt="Shoes" class="rounded-xl" />
                </figure>
                <h2 class="card-title">${markerData.position.title}</h2>
                    <p>${markerData.position.description}</p>
            `);
            map.panTo(markerData.position);
            markers.push(marker);
        }
    }

    function generateMarker(data, index) {
        return L.marker(data.position, {
            draggable: data.draggable
        })
            .on('click', (event) => markerClicked(event, index))
            .on('dragend', (event) => markerDragEnd(event, index));
    }

    /* ------------------------- Handle Map Click Event ------------------------- */
    function mapClicked($event) {
        console.log(map);
        console.log($event.latlng.lat, $event.latlng.lng);
    }

    /* ------------------------ Handle Marker Click Event ----------------------- */
    function markerClicked($event, index) {
        console.log(map);
        console.log($event.latlng.lat, $event.latlng.lng);
    }

    /* ----------------------- Handle Marker DragEnd Event ---------------------- */
    function markerDragEnd($event, index) {
        console.log(map);
        console.log($event.target.getLatLng());
    }

    /* ----------------------------- Fetch Map Data ----------------------------- */
    function fetchMapData() {
        return fetch('/api/maps') // Ganti dengan URL yang sesuai dengan rute API Anda.
            .then(response => response.json())
            .then(data => {
                return data.data.initialMarkers.position;
            })
            .catch(error => {
                console.error('Gagal mengambil data peta:', error);
            });
    }
</script>

<script type="text/javascript">
    function confirmDelete() {
        if (!confirm("Are You Sure to delete this"))
            event.preventDefault();
    }
</script>


@endpush