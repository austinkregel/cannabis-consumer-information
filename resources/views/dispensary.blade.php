<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight pl-6">
            {{ $dispensary->name }}
        </h2>
        <p class="text-sm font-medium text-slate-700 dark:text-slate-200 truncate pl-6">
            {{ $dispensary->official_license_type }}
        </p>
    </x-slot>
    <x-slot name="scripts">
      
      <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap&v=weekly"
        defer
      ></script>
      <script>
        function initMap() {
          const dispensary = { lat: {{$dispensary->latitude}}, lng: {{$dispensary->longitude}} };
          const map = new google.maps.Map(document.getElementById("map"), {
            center: dispensary,
            zoom: 10,
          });
          const contentString = '<div id="content">{{ $dispensary->name }}</div>';

          const infowindow = new google.maps.InfoWindow({
            content: contentString,
          });

          const marker = new google.maps.Marker({
            position: dispensary,
            map,
            title: "{{ $dispensary->name}}",
          });

          marker.addListener("click", () => {
            infowindow.open({
              anchor: marker,
              map,
              shouldFocus: false,
            });
          });
        }
      </script> 
    </x-slot>

    <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8 mt-6">
        <!-- Replace with your content -->
     
        <div class="flow-root mt-6 bg-white dark:bg-slate-600 rounded-lg">
          <div class="flex flex-col space-x-4">
            <div class="flex-1 min-w-0">
              <div id="map" class="w-full h-48 bg-white rounded-t"></div>
              <pre class="text-sm text-slate-500 dark:text-slate-300">{{ json_encode($dispensary, JSON_PRETTY_PRINT) }}</pre>
              <div class="p-4 text-slate-700 dark:text-slate-200">
                <div class="text-xl">
                  <label class="sr-only">Dispensary Name</label>
                  <span>{{ $dispensary->name }}</span>
                </div>
                <div class="text-sm flex items-center">
                  <label>License Number</label>
                  <svg class="w-6 h-6 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>  
                  <span>{{ $dispensary->license_number }}</span>
                </div>
                @if($dispensary->official_license_type)
                <div class="text-sm flex items-center">
                  <label>License Type</label>
                  <svg class="w-6 h-6 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                  <span>{{ $dispensary->official_license_type }}</span>
                </div>
                @endif
                @if($dispensary->url)
                <div class="text-sm">
                  <label>Website</label>:
                  <span>{{ $dispensary->url }}</span>
                </div>
                @endif
                @if($dispensary->address)
                <div class="text-sm flex items-center">
                  <label>Address</label>
                  <svg class="w-6 h-6 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>  
                  <span>{{ $dispensary->address }}</span>
                </div>
                @endif
                @if($dispensary->email)
                <div class="text-sm">
                  <label>Email</label>:
                  <span>{{ $dispensary->email }}</span>
                </div>
                @endif

                @if($dispensary->phone_number)
                <div class="text-sm">
                  <label>Phone Number</label>:
                  <span>{{ $dispensary->phone_number }}</span>
                </div>
                @endif
                @if($dispensary->is_recreational)
                <div class="text-sm flex items-center">
                  <label>Recreational</label>
                  <svg class="w-6 h-6 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"></path></svg> 
                </div>
                @else
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                @endif 
              </div>
            </div>
          </div>
        </div>
    </div>
</x-app-layout>
