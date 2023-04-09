<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-screen w-full bg-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="{{ url('/css/app.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased h-screen w-full">
<div id="map" class="bg-white h-screen w-full" ></div>

<script>
    window.initMap = () => {
        const infoWindow = new google.maps.InfoWindow();
        const zipCode = {lat: {{$zip->lat}}, lng: {{$zip->lng}}};
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 7,
            center: zipCode,
        });

        const recreational = {
            path: "M-1.547 12l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM0 0q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
            fillColor: "blue",
            fillOpacity: 0.6,
            strokeWeight: 0,
            rotation: 0,
            scale: 1,
            anchor: new google.maps.Point(0, 20),
        };

        const medicinal = {
            path: "M-1.547 12l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM0 0q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
            fillColor: "red",
            fillOpacity: 0.6,
            strokeWeight: 0,
            rotation: 0,
            scale: 1,
            anchor: new google.maps.Point(0, 20),
        };
        @php $licenses = []; @endphp
        const markers = [
        @foreach (App\Models\Dispensary::query() ->whereNotNull('latitude') ->whereNotNull('longitude') ->get() as $dispensary)
            new google.maps.Marker({
                position: {
                    lat: {{ $dispensary->latitude }},
                    lng: {{ $dispensary->longitude }},
                },
                map: map,
                title: "{{ $dispensary->name }}",
                extra: {
                    address: "{{ $dispensary->address }}",
                    phone_number: "{{ $dispensary->phone_number }}",
                    is_recreational: "{{ $dispensary->is_recreational }}",
                    official_license_type: "{{ $dispensary->official_license_type }}",
                },
                icon: "{{ 'http://localhost/' .$dispensary->license_type.'.png' }}",
                optimize: true
            }),
            @php if (in_array($dispensary->license_type, $licenses)) { array_push($licenses, $dispensary->license_type); } @endphp
        @endforeach
        ];


        markers.forEach((marker, i) => {
            marker.addListener("click", () => {
                infoWindow.close();
                infoWindow.setContent(
                    marker.title+"<br/>"
                    +(marker.extra.address ? '<a class="text-blue-500" href="https://www.google.com/search?q=' + marker.extra.address.replace(' ', '+') +'">'+marker.extra.address+'</a>': marker.extra.address)+"<br/>"
                    +(marker.extra.phone_number ?? 'No phone number on record')+"<br/>"
                    +(marker.extra.official_license_type ?? '')+"<br/>"
                    +(marker.extra.is_recreational ? 'Recreational' : 'Medical')
                );
                infoWindow.open(map, marker);
            });
        });

    }
</script>
<!-- Async script executes immediately and must be after any DOM elements used in callback. -->
<script
    async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4ahgQ9KI87fyW1fM4C0FCXylkggcJqkY&libraries=visualization&v=weekly&callback=initMap"
></script>
</body>
</html>
