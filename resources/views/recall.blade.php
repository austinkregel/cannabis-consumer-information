@php
function get_center($coords)
{
    $count_coords = count($coords);
    if ($count_coords == 0) {
        // More or less the center of michigan...
        return [44.7116612,-85.8790665];
    }
    $xcos=0.0;
    $ycos=0.0;
    $zsin=0.0;    
    foreach ($coords as $lnglat)
    {
        $lat = $lnglat['lat'] * pi() / 180;
        $lon = $lnglat['lng'] * pi() / 180;
        
        $acos = cos($lat) * cos($lon);
        $bcos = cos($lat) * sin($lon);
        $csin = sin($lat);
        $xcos += $acos;
        $ycos += $bcos;
        $zsin += $csin;
    }

    $xcos /= $count_coords;
    $ycos /= $count_coords;
    $zsin /= $count_coords;
    $lon = atan2($ycos, $xcos);
    $sqrt = sqrt($xcos * $xcos + $ycos * $ycos);
    $lat = atan2($zsin, $sqrt);
    
    return array($lat * 180 / pi(), $lon * 180 / pi());
}

@endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight pl-6">
                {{ $recall->name }}
            </h2>
            <div>
                <follow-button 
                    v-if="$store.getters.user?.id"
                    type="App\Models\Recall" 
                    :follow="{{$recall}}" 
                    class="text-green-600 dark:text-green-400"
                ></follow-button>    
                <favorite-button 
                    v-if="$store.getters.user?.id"
                    type="App\Models\Recall" 
                    :follow="{{$recall}}" 
                    class="text-yellow-600 dark:text-yellow-400"
                ></favorite-button>
            </div>
        </div>
    </x-slot>

    <x-slot name="scripts">
      
      <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap&v=weekly"
        defer
      ></script>
      <script>
        function initMap() {
        @php
        $center = get_center($recall->dispensaries->map(fn (App\Models\Dispensary $dispensary) => ['lat' => $dispensary->latitude, 'lng' => $dispensary->longitude])->filter(fn ($lnglat) => $lnglat['lat'] && $lnglat['lng']));
        @endphp
          const dispensary = { lat: {{$center[0]}}, lng: {{$center[1]}} };
          const map = new google.maps.Map(document.getElementById("map"), {
            center: dispensary,
            zoom: 6,
          });
          const contentString = '<div id="content">{{ $recall->name }}</div>';

          const infowindow = new google.maps.InfoWindow({
            content: contentString,
          });

          @foreach($recall->dispensaries as $dispensary)
          @if ($dispensary->latitude && $dispensary->longitude)
          new google.maps.Marker({
            position: {
                lat: {{ $dispensary->latitude ?? 0}},
                lng: {{ $dispensary->longitude ?? 0}},
            },
            map,
            title: "{{ $dispensary->name}}",
          });
          @endif
          @endforeach
        }
      </script> 
    </x-slot>

    <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8 mt-6 text-slate-800 dark:text-white">
        <div id="map" class="w-full bg-white rounded-t" style="height: 400px"></div>

        <div class="bg-white dark:bg-slate-600 rounded-b-lg shadow p-4">
            <div>
                {{ $recall->recommended_actions ?? '' }}
            </div> 
            <div class="{{ $recall->recommended_actions ? 'mt-4' : '' }}">
                Published {{ $recall->pretty_published_at}}
            </div>
            <div class="text-xl mt-4 mb-2">
                Impacting {{ $recall->products_count }} products
            </div>

            @if ($recall->products_count === 0)
                <p class="text-sm text-slate-500 dark:text-slate-300 truncate">
                    Hmmm... This isn't right, this indicates our server is having a tough time scanning the PDF. You're a human, 
                    <a target="_blank" href="{{$recall->mra_public_notice_url}}" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-slate-300 dark:border-slate-600 text-sm leading-5 font-medium rounded-full text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800">
                        <svg class="mr-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        can you give the published PDF a read for us? 
                    </a>
                </p>
            @else
                <div class="h-32 overflow-y-scroll border border-slate-200 dark:border-slate-500 p-4 rounded-lg">
                @foreach ($recall->products as $product)
                    <div>
                        {{ $product->product_id }}   
                        {{ $product->name }}   
                    </div>

                @endforeach
                </div>
            @endif

            <div class="text-xl mt-4 mb-2">Impacted Establishments</div>
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                @foreach ($recall->dispensaries as $dispensary)
                <div class="relative rounded-lg border border-slate-300 dark:border-slate-500 bg-white dark:bg-slate-600 dark:hover:bg-slate-700 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-slate-400 dark:hover:border-slate-700 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                    <div class="flex-1 min-w-0">
                        <p class="text-lg font-medium text-slate-900 dark:text-slate-50 truncate">
                        {{ $dispensary->name }}
                        </p>
                        <p class="text-sm text-slate-500 dark:text-slate-300 truncate">
                        {{ $dispensary->official_license_type ?? 'No public data exists for this facility' }}
                        </p>
                        <p class="text-sm text-slate-500 dark:text-slate-300 truncate">
                        {{ $dispensary->address ?? $dispensary->license_number }}
                        </p>
                        <p class="text-sm text-slate-500 dark:text-slate-300 truncate">
                        Involved in {{ $dispensary->recalls_count }} recalls
                        </p>
                    </div>
                    <div class="text-right">
                        <a href="/dispensary/{{$dispensary->license_number}}" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-slate-300 dark:border-slate-600 text-sm leading-5 font-medium rounded-full text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800">View {{$dispensary->license_type}} facility</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
