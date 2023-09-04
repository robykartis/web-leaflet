@extends('layouts.main')

@section('content')
<div class="container w-full-xl md:max-w-6xl mx-auto pt-4 pb-10">
    <div class="w-full px-4 md:px-6 text-xl text-gray-800 leading-normal" style="font-family:Georgia,serif;">
        <!--Author-->
        <div class="flex w-full items-center font-sans px-4 py-8">
            <img class="w-10 h-10 rounded-full mr-4" src="http://i.pravatar.cc/300" alt="Avatar of Author">
            <div class="flex-1 px-2">
                <p class="text-base font-bold md:text-xl leading-none mb-2">Jo Bloggerson</p>
                <p class="text-gray-600 text-xs md:text-base">Minimal Blog Tailwind CSS template by <a
                        class="text-green-500 no-underline hover:underline" href="#">sianu</a></p>
            </div>

        </div>
        <!--/Author-->
        <!--Title-->

        <div id="content" class="container max-w-full">
            <div class="font-sans bg-gradient-to-b from-green-100 to-gray-100 rounded-lg shadow-xl p-4 text-center">
                <h2 class="font-bold break-normal text-xl md:text-3xl py-2">MAPS</h2>
                <div class="w-full text-center">

                    <div id="map" class="rounded-lg" style="width: 100%; height: 450px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    const map = L.map('map').setView([51.505, -0.09], 13);

const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

const marker = L.marker([51.5, -0.09]).addTo(map)
    .bindPopup('<b>Hello world!</b><br />I am a popup.').openPopup();

const circle = L.circle([51.508, -0.11], {
    color: 'red',
    fillColor: '#f03',
    fillOpacity: 0.5,
    radius: 500
}).addTo(map).bindPopup('I am a circle.');

const polygon = L.polygon([
    [51.509, -0.08],
    [51.503, -0.06],
    [51.51, -0.047]
]).addTo(map).bindPopup('I am a polygon.');


const popup = L.popup()
    .setLatLng([51.513, -0.09])
    .setContent('I am a standalone popup.')
    .openOn(map);

function onMapClick(e) {
    popup
        .setLatLng(e.latlng)
        .setContent(`You clicked the map at ${e.latlng.toString()}`)
        .openOn(map);
}

map.on('click', onMapClick);

</script>
@endpush