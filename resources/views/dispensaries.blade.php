<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight pl-6">
            {{ __('Facilities') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8 mt-6">
        <filterable-grid :items="{{ json_encode($dispensaries->items()) }}" >
          <template #item="{ item }">
            <div class="flex items-center space-x-4">
              <div class="flex-1 min-w-0">
                <p class=" pl-8 text-lg font-medium text-slate-900 dark:text-slate-50 truncate">
                  @{{ item.name }}
                </p>
                <p class="flex items-center text-base text-slate-500 dark:text-slate-300 truncate">
                  <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                  @{{ item.official_license_type }}
                </p>
                <p class="flex items-center text-base text-slate-500 dark:text-slate-300">
                  <svg class="w-6 h-6 mr-2 text-blue-600 dark:text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>  
                  <span class="flex-1 truncate">@{{ item.address }}</span>
                </p>
              </div>
              <div>
                <a :href="'/dispensary/' + item.license_number" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-slate-300 dark:border-slate-600 text-sm leading-5 font-medium rounded-full text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800"> View </a>
              </div>
            </div>

          </template>

        </filterable-grid>
        <div class="flex flex-col flex-reverse mt-2">
            {{ $dispensaries->links() }}
        </div>
    </div>
</x-app-layout>
