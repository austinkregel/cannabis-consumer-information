<template>
    <div>
        <div class="flex flex-col gap-4 bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-4">
            <div>
                <label for="metrc_code" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Metrc Code(s)</label>
                <div class="mt-1">
                    <input v-model="code" name="metrc_code" id="metrc_code" class="py-2 px-4 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-600 dark:text-gray-200 rounded-md" />
                </div>
            </div>
            <div>
                <button @click="scan = !scan" type="button" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    
                    <span>Scan product</span>
                </button>

                <div v-if="scan" class="flex flex-wrap justify-center w-full bg-gray-800">
                    <div class="max-w-xl">
                        <StreamBarcodeReader @decode="onDecode" @loaded="onLoaded"></StreamBarcodeReader>
                        <div class="text-sm text-white text-center">You can scan as many products as you'd like.</div>
                    </div>
                </div>
            </div>
            <div>
                <button class="bg-blue-500 px-2 py-1 rounded text-white" @click="searchForRecalls" type="submit">
                    Search for recalls
                </button>
            </div>
            <div class="text-gray-900 dark:text-gray-300">
                <div v-for="recall in recalls" :key="recall.id">
                    <div class="rounded-md bg-yellow-50 dark:bg-yellow-700 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <ExclamationIcon class="h-5 w-5 text-yellow-400" aria-hidden="true" />
                            </div>
                            <div class="ml-3">
                                <a class="text-sm font-medium text-yellow-800 dark:text-yellow-50 underline" :href="recall.mra_public_notice_url">{{recall.name}}</a>
                                <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-50">
                                    <p v-for="product in recall.products" :key="product.id">{{product.name}} &mdash; {{product.id}}</p>
                                </div>
                                <div class="w-full text-yellow-700 dark:text-yellow-50 mt-2 text-sm">Published {{recall.pretty_published_at}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref } from 'vue'
import { StreamBarcodeReader } from "vue-barcode-reader";
import { ExclamationIcon } from '@heroicons/vue/solid'

export default defineComponent({
   components: {
       StreamBarcodeReader,
       ExclamationIcon
   },
    methods: {
        onDecode(code) {
            this.decoded = [...new Set([...this.decoded, code])];
            
            this.code = this.decoded.join(', ');
        },
        onLoaded() {
            this.loading = false;
        },
        searchForRecalls() {
            this.scan = false;
            axios.post('/api/search', {
                products: this.code?.split(',').map(code => code.trim()).filter(code => code.length),
            })
            .then((res) => {
                this.recalls = res.data;
            })
        }
    },
    data() {
        return {
            code: '',
            loading: false,
            scan: false,
            decoded: [],
            recalls: [],
            console,
        }
    }
})
</script>
