<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight pl-6">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8 mt-6">
     
        <filterable-grid :items="{{ json_encode($dispensaries->items()) }}" >
          <template #item="{ item }">
            <div class="flex items-center space-x-4">
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-slate-900 dark:text-slate-50 truncate">
                @{{ item.name }}
                </p>
                <p class="text-sm text-slate-500 dark:text-slate-300 truncate">
                @{{ item.official_license_type }}
                </p>
                <p class="text-sm text-slate-500 dark:text-slate-300 truncate">
                @{{ item.address }}
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
