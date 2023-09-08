@extends('admin.layouts.app')
@section('title')
    {{ $title }}
@endsection
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-locatecontrol/0.79.0/L.Control.Locate.css">
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
                        <h2 class="card-title">{{ $title }}</h2>
                        <div class="flex flex-wrap gap-3">
                            <div class="form-control w-full md:w-1/2 lg:w-1/4">
                                <label class="input-group input-group-vertical">
                                    <span>Nama Lokasi</span>
                                    <input type="text" name="title" value="{{ old('title') }}"
                                        placeholder="Nama Lokasi"
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


                            <div class="form-control w-full md:w-1/2 lg:w-1/5">
                                <label class="input-group input-group-vertical">
                                    <span>Foto</span>
                                    <input type="file" name="image"
                                        class="file-input file-input-bordered file-input-accent w-full xl:w-full ax-w-xs @error('image') is-invalid @enderror" />
                                    @error('image')
                                        <p class="text-red-600 text-sm">{{ $message }}</p>
                                    @enderror
                                </label>
                            </div>
                        </div>
                        <div class="form-control w-full md:w-1/2 lg:w-full py-2">
                            <label class="input-group input-group-vertical">
                                <span>Deskripsi</span>
                                <textarea name="description" class="textarea textarea-accent @error('description') is-invalid @enderror"
                                    placeholder="Deskripsi">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>

                        <div id="map" class="rounded-lg" style="width: 100%; height: 450px;"></div>
                        <div class="card-actions justify-end">
                            <a href="{{ route('maps.index') }}" class="btn btn-info text-white">Kembali</a>
                            <button type="submit" class="btn btn-accent text-white">Simpan</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-locatecontrol/0.79.0/L.Control.Locate.min.js"></script>

    <script>
        let markers = [];
        /* ----------------------------- Initialize Map ----------------------------- */
        var centerLatitude = 0.5392885884326033;
        var centerLongitude = 101.44369122944886;

        // map = L.map('map', {
        //     center: {
        //         lat: centerLatitude,
        //         lng: centerLongitude,
        //     },
        //     zoom: 10
        // });

        // Initiate map ID
        var position = [centerLatitude, centerLongitude];
        var zoom = 10;
        var map = L.map('map', {
            minZoom: 8,
            maxZoom: 18,
            zoomSnap: 0,
            zoomDelta: 0.25,
            fullscreenControl: {
                pseudoFullscreen: true // if true, fullscreen to page width and height
            }
        }).setView(position, zoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        map.on('click', mapClicked);
        // initMarkers();

        // Add current location
        showCurrentPoint(position, map);


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

        function showCurrentPoint(position, map, myIcon = null) {
            var location = L.marker(position, {
                draggable: true
            }).addTo(map);
            location.on('dragend', function(e) {
                // $('#latInput').val(e.target._latlng.lat);
                // $('#lngInput').val(e.target._latlng.lng);
                // $('#map_tipe').val("HYBRID");
                // $('#zoom').val(map.getZoom());

                document.querySelector('input[name="lat"]').value = e.target._latlng.lat;
                document.querySelector('input[name="lng"]').value = e.target._latlng.lng;
                // document.querySelector('#map_tipe').value = 'HYBRID';
                // document.querySelector('#zoom').value = map.getZoom();
            })

            map.on('zoomstart zoomend', function(e) {
                // $('#zoom').val(map.getZoom());
                // document.querySelector('#zoom').value = map.getZoom();
            })

            var lc = L.control.locate({
                flyTo: false,
                keepCurrentZoomLevel: false,
                showCompass: true,
                drawCircle: true,
                drawMarker: true,
                icon: 'fas fa-map-marker-alt',
                strings: {
                    title: "Lokasi Saya",
                    popup: "Anda berada disekitar {distance} {unit} dari titik ini",
                    locateOptions: {
                        watch: true,
                        enableHighAccuracy: true
                    },
                }
            }).addTo(map);

            map.on('locationfound', function(e) {
                // $('#latInput').val(e.latlng.lat);
                // $('#lngInput').val(e.latlng.lng);

                document.querySelector('input[name="lat"]').value = e.latlng.lat;
                document.querySelector('input[name="lng"]').value = e.latlng.lng;

                location.setLatLng(e.latlng);
                map.setView(e.latlng);
                var radius = e.accuracy;
                L.circle(e.latlng, radius).addTo(map);
            });
            // map.on('locationerror', function(e) {
            //     alert(e.message);
            // });
            map.on('startfollowing', function() {
                map.on('dragstart', lc._stopFollowing, lc);
            }).on('stopfollowing', function() {
                map.off('dragstart', lc._stopFollowing, lc);
            });

            return showCurrentPoint;
        }
    </script>
@endpush
