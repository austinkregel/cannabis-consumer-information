<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Recalls') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ code: '', loading: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="/recall-check" method="POST" class="flex flex-col gap-4 bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-4">
                @csrf
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Code</label>
                    <div class="mt-1">
                        <textarea x-model="code" rows="4" name="comment" id="comment" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-600 dark:text-gray-200 rounded-md">
                        </textarea>
                    </div>
                </div>
                <div>
                    <button type="button">Scan product</button>
                </div>
                <div>
                    <button class="bg-blue-500 px-2 py-1 rounded text-white" x-on:click="() => loading = true" type="submit">Search for recalls</button>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{ recalls: {{ $recalls}} }">
            <div>
                <div class="text-3xl text-gray-900 dark:text-gray-50 py-2 px-4">
                    Known recalls
                </div>
            </div>
            <div class="flex flex-col gap-4 bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-2">
                <template x-for="recall in recalls" x-key="recall.id">
                    <div class="bg-white text-gray-900 dark:bg-gray-600 dark:text-white py-2 px-2 rounded" >
                        <div class="font-bold">
                            <a target="_blank" :href="recall.mra_public_notice_url"  x-text="recall.name"></a>
                        </div>
                        <div>
                            <span x-text="recall.published_at"></span>
                            
                        </div>
                        <div>Impacted Products <span x-text="recall.products_count">/span></div>
                    </div>
                </template>

                <pre x-text="JSON.stringify(recalls, null, 4)"></pre>
            </div>
        </div>
    </div>
</x-app-layout>
