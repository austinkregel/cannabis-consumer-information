<x-app-layout>
    <x-slot name="header">
      <div class="flex items-center space-x-3">
        <h3 class="text-gray-900 dark:text-gray-50 text-2xl font-medium truncate">{{ $dispensary->name }}</h3>
        <span class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 dark:text-green-200 dark:bg-green-800 text-xs font-medium bg-green-100 rounded-full">{{ $dispensary->license_number }}</span>
      </div>
      <p class="mt-1 text-gray-500 dark:text-gray-300 text-sm truncate">{{ $dispensary->official_license_type }}</p>
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
              <div class="text-slate-700 dark:text-slate-200">
                <div class="w-full flex items-center justify-between p-6 space-x-6">
                    <div class="max-w-2xl grid grid-cols-3 row-auto text-sm w-full gap-2 mt-2 tracking-wide">
                      <label class="text-base">License Number</label>
                      <div class="flex items-center col-span-2">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>  
                        {{ $dispensary->license_number }}
                      </div>
                      @if($dispensary->official_license_type)
                        <label class="text-base">License Type</label>
                        <div class="flex items-center col-span-2">
                          <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                          {{ $dispensary->official_license_type }}
                        </div>
                      @endif
                      @if($dispensary->url)
                        <label class="text-base">Website</label>:
                        <span class="col-span-2">{{ $dispensary->url }}</span>
                      @endif
                      @if($dispensary->address)
                        <label class="text-base">Address</label>
                        <div class="flex items-center col-span-2">
                          <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>  
                          {{ $dispensary->address }}
                        </div>
                      @endif
                      @if($dispensary->email)
                        <label class="text-base">Email</label>:
                        <span class="col-span-2">{{ $dispensary->email }}</span>
                      @endif

                      @if($dispensary->phone_number)
                        <label class="text-base">Phone Number</label>:
                        <span class="col-span-2">{{ $dispensary->phone_number }}</span>
                      @endif
                        <label class="text-base">Recreational</label>
                        <div class="flex items-center col-span-2">
                          @if($dispensary->is_recreational)
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                          @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                          @endif 
                          {{ $dispensary->is_recreational ? 'Yes' : 'No' }}
                        </div>
                        <label class="text-base">Is Presently Active</label>
                        <div class="flex items-center col-span-2">
                          @if($dispensary->is_active)
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                          @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                          @endif 
                          {{ $dispensary->is_active ? 'Yes' : 'No' }}
                        </div>

                        <label class="text-base">License Expires On</label>
                        <div class="flex items-center col-span-2">
                          <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>  
                          {{ $dispensary->license_expires_at->format('F j, Y') }}
                        </div>
                    </div>
                </div>
                <div>
                  <div class="-mt-px flex divide-x divide-gray-200">
                    @if($dispensary->email)
                    <div class="w-0 flex-1 flex">
                      <a href="mailto:{{ $dispensary->email }}" class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 dark:text-gray-100 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                        <MailIcon class="w-5 h-5 text-gray-400 dark:text-gary-100" aria-hidden="true" />
                        <span class="ml-3">Email</span>
                      </a>
                    </div>
                    @endif
                    @if($dispensary->phone_number)
                    <div class="-ml-px w-0 flex-1 flex">
                      <a href="tel:{{ $dispensary->phone_number }}" class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 dark:text-gray-100 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                        <PhoneIcon class="w-5 h-5 text-gray-400 dark:text-gary-100" aria-hidden="true" />
                        <span class="ml-3">Call</span>
                      </a>
                    </div>
                    @endif
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</x-app-layout>
