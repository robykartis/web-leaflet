@extends('admin.layouts.app')
@section('title')
{{ $title }}
@endsection
@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush
@section('breadcrumbs')
{{ Breadcrumbs::render() }}
@endsection
@section('content')
<div class="flex flex-row flex-wrap flex-grow mt-2">
    <div class="w-full p-3">
        {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif --}}
        <div class="card card-side bg-base-100 shadow-xl">
            <form action="{{ route('maps.store') }}" method="POST" class="w-full" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="card-body">
                    <h2 class="card-title">{{$title}}</h2>
                    <div class="flex flex-wrap gap-3">
                        <div class="form-control w-full md:w-1/2 lg:w-1/4">
                            <label class="input-group input-group-vertical">
                                <span>Title</span>
                                <input type="text" name="title" value="{{ old('title') }}" placeholder="Title"
                                    class="input input-accent input-bordered  @error('title') is-invalid @enderror" />
                                @error('title')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>
                        <div class="form-control w-full md:w-1/2 lg:w-1/4">
                            <label class="input-group input-group-vertical">
                                <span>Latitude</span>
                                <input type="text" id="latInput" name="lat" value="{{ old('lat') }}"
                                    placeholder="Latitude"
                                    class="input input-accent input-bordered @error('lat') is-invalid @enderror" />
                                @error('lat')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>
                        <div class="form-control w-full md:w-1/2 lg:w-1/4">
                            <label class="input-group input-group-vertical">
                                <span>Longitude</span>
                                <input type="text" id="lngInput" name="lng" value="{{ old('lng') }}"
                                    placeholder="Longitude"
                                    class="input input-accent input-bordered @error('lng') is-invalid @enderror" />
                                @error('lng')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>


                        <div class="form-control w-full md:w-1/2 lg:w-1/4">
                            <label class="input-group input-group-vertical">
                                <span>Foto</span>
                                <input type="file" name="image"
                                    class="file-input file-input-bordered file-input-accent w-full max-w-xs @error('image') is-invalid @enderror" />
                                @error('image')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>
                    </div>
                    <div class="form-control w-full md:w-1/2 lg:w-full py-2">
                        <label class="input-group input-group-vertical">
                            <span>Description</span>
                            <textarea name="description"
                                class="textarea textarea-accent @error('description') is-invalid @enderror"
                                placeholder="Description">{{old('description')}}</textarea>
                            @error('description')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>

                    <div id="map" class="rounded-lg" style="width: 100%; height: 450px;"></div>
                    <div class="card-actions justify-end">
                        <a href="{{ route('maps.index') }}" class="btn btn-info">Back</a>
                        <button type="submit" class="btn btn-accent">Save</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection
@push('js')
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
                lat: 28.626137,
                lng: 79.821603,
            },
            zoom: 10
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        map.on('click', mapClicked);
        initMarkers();
    }
    initMap();



    /* --------------------------- Drak Markers --------------------------- */
    function updateLatLngInputs(marker) {
        const latInput = document.querySelector('input[name="lat"]');
        const lngInput = document.querySelector('input[name="lng"]');

        const latLng = marker.getLatLng();
        latInput.value = latLng.lat.toFixed(7); // Menggunakan toFixed untuk membatasi jumlah desimal.
        lngInput.value = latLng.lng.toFixed(7);
}
    /* --------------------------- Initialize Markers --------------------------- */
    function initMarkers() {
        const initialMarkers = <?php echo json_encode($initialMarkers); ?>;

        for (let index = 0; index < initialMarkers.length; index++) {
        const data = initialMarkers[index];
        const marker = generateMarker(data, index);

        marker.addTo(map).bindPopup(`<b>${data.position.lat},  ${data.position.lng}</b>`);
        map.panTo(data.position);
        markers.push(marker);

        marker.on('dragend', (event) => {
            updateLatLngInputs(event.target);
            markerDragEnd(event, index);
        });
    }
    }

    function generateMarker(data, index) {
    return L.marker(data.position, {
        draggable: data.draggable
    })
    .on('click', (event) => markerClicked(event, index));
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
    fetch('/api/maps') // Ganti dengan URL yang sesuai dengan rute API Anda.
        .then(response => response.json())
        .then(data => {
            const initialMarkers = data.data.initialMarkers.position;
            initMarkers(initialMarkers); // Panggil fungsi initMarkers dengan data yang diambil dari API.
        })
        .catch(error => {
            console.error('Gagal mengambil data peta:', error);
        });
}

</script>
@endpush