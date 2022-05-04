<template>
    <div>
        <form action="/recall-check" method="POST" class="flex flex-col gap-4 bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-4">
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
        </form>
    </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    setup() {
        
    },
})
</script>
