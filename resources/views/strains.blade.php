<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight pl-6">
            {{ __('Strains') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8 mt-6">
        <filterable-grid :items="{{ json_encode($strains->items()) }}" >
          <template #item="{ item }">
            <div class="w-full flex flex-col sm:flex-row items-center space-x-4 space-y-4 md:space-y-0">
              <div class="flex-1 min-w-0 w-full">
                <p class="w-full pl-8 text-lg font-medium text-slate-900 dark:text-slate-50 truncate overflow-hidden">
                  @{{ item.name }}
                </p>
              </div>
              <div class="flex-1 flex items-center gap-2 justify-center md:justify-end">
                <favorite-button v-if="$store.getters.user?.id" type="App\Models\Strain" :follow="item" class="text-yellow-600 dark:text-yellow-400"></favorite-button>
                <follow-button v-if="$store.getters.user?.id" type="App\Models\Strain" :follow="item" class="text-green-600 dark:text-green-400"></follow-button>
                <like-button v-if="$store.getters.user?.id" type="App\Models\Strain" :follow="item" class="text-blue-600 dark:text-blue-400"></like-button>
         
                <a :href="'/dispensary/' + item.license_number" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-slate-300 dark:border-slate-600 text-sm leading-5 font-medium rounded-full text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800">
                  View
                </a>
              </div>
            </div>

          </template>

        </filterable-grid>
        <div class="flex flex-col flex-reverse mt-2">
            {{ $strains->links() }}
        </div>
    </div>
</x-app-layout>
