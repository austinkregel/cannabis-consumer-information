<template>
    <div>
        <div class="bg-white dark:bg-slate-700 rounded-lg shadow px-5 py-6 sm:px-6">
          <div>
            <label for="metrc_code" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Metrc Product Code</label>
            <div class="mt-1 flex rounded-md shadow-sm">
              <div class="relative flex items-stretch flex-grow focus-within:z-10">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <QrcodeIcon class="h-5 w-5 text-slate-400 dark:text-slate-100" aria-hidden="true" />
                </div>
                <input v-model="code" type="metrc_code" name="metrc_code" id="metrc_code" class="dark:text-slate-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none rounded-l-md pl-10 sm:text-sm border-slate-300 dark:border-slate-500 dark:bg-slate-600" placeholder="1A40530000..., 1A405..." />
              </div>
              <button @click="scan = !scan" type="button" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-slate-300 dark:border-slate-700 text-sm font-medium rounded-r-md text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                <VideoCameraIcon class="fill-current h-5 w-5 text-slate-400 dark:text-slate-200" aria-hidden="true" />
                <span>Scan</span>
              </button>
            </div>
            
              <button @click="searchForRecalls" type="button" class="-ml-px mt-2 relative inline-flex items-center space-x-2 px-4 py-2 border border-slate-300 dark:border-slate-700 text-sm font-medium rounded-md text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                <span>Add product<span v-if="code.split(',').filter(k => k).length != 1">s</span></span>
              </button>
          </div>
          
            <div v-if="scan" class="flex flex-wrap justify-center w-full bg-slate-800">
                <div class="max-w-xl">
                    <StreamBarcodeReader @decode="onDecode" @loaded="onLoaded"></StreamBarcodeReader>
                    <div class="text-sm text-white text-center">You can scan as many products as you'd like.</div>
                </div>
            </div>
        </div>
        <div v-if="decoded.length > 0" class="mt-5 md:col-span-2">
            <form action="#" method="POST">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white dark:bg-slate-600 sm:p-6 gap-6 flex flex-col divide-slate-200 dark:divide-slate-500 divide-y divide-solid -mt-4">
                    <div class="grid grid-cols-6 gap-4 pt-6" v-for="product in decoded" :key="product.id">
                        <div class="col-span-6 sm:col-span-4">
                            <label for="product_id" class="block text-sm font-medium text-slate-700 dark:text-slate-200">Product ID (usually called a Metrc Tag, or a source tag)</label>
                            <input v-model="product.product_id" type="text" name="product_id" id="product_id" class="dark:bg-slate-500 dark:border-slate-500 mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full dark:text-slate-200 shadow-sm sm:text-sm border-slate-300 rounded-md" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">What was the primary strain? (Optional)</label>
                            <searchable-input 
                                v-model="product.strain_id"
                                url="/api/strains"
                                :urlOptions="{ }"
                                @change="newValue => product.name = newValue.name"
                            >
                                <template #option="{ option }">
                                    <div class="flex flex-col gap-1">
                                        <p class="text-sm font-medium text-slate-900 dark:text-slate-50 flex items-center gap-2">
                                            <span>{{ option.name }}</span>
                                        </p>
                                    </div>
                                </template>
                            </searchable-input>
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Dispensary Purchased At (Optional)</label>
                            <searchable-input 
                                v-model="product.dispensary_id"
                                url="/api/facilities"
                                :urlOptions="{ filter: { license_type: 'in:retailer,provisioning'} }"
                            >
                                <template #option="{option}">
                                    <div class="flex flex-col gap-1">
                                        <p class="text-sm font-medium text-slate-900 dark:text-slate-50 flex items-center gap-2">
                                            <span>{{ option.name }}</span>
                                            <span class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 dark:text-green-200 dark:bg-green-800 text-xs font-medium bg-green-100 rounded-full">{{ option.license_number }}</span>
                                        </p>
                                        <p class="text-sm text-slate-500 dark:text-slate-300">{{ option.license_type }} &mdash; {{ option.address }}</p>
                                    </div>
                                </template>
                            </searchable-input>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Testing Facility (Optional)</label>
                            <searchable-input 
                                v-model="product.tester_id"
                                url="/api/facilities"
                                :urlOptions="{ filter: { license_type: 'compliance'} }"
                            >
                                <template #option="{option}">
                                    <div class="flex flex-col gap-1">
                                        <p class="text-sm font-medium text-slate-900 dark:text-slate-50 flex items-center gap-2">
                                            <span>{{ option.name }}</span>
                                            <span class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 dark:text-green-200 dark:bg-green-800 text-xs font-medium bg-green-100 rounded-full">{{ option.license_number }}</span>
                                        </p>
                                        <p class="text-sm text-slate-500 dark:text-slate-300">{{ option.license_type }} &mdash; {{ option.address }}</p>
                                    </div>
                                </template>
                            </searchable-input>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Who grew it (Optional)</label>
                            <searchable-input 
                                v-model="product.grower_id"
                                url="/api/facilities"
                                :urlOptions="{ filter: { license_type: 'grower'} }"
                            >
                                <template #option="{option}">
                                    <div class="flex flex-col gap-1">
                                        <p class="text-sm font-medium text-slate-900 dark:text-slate-50 flex items-center gap-2">
                                            <span>{{ option.name }}</span>
                                            <span class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 dark:text-green-200 dark:bg-green-800 text-xs font-medium bg-green-100 rounded-full">{{ option.license_number }}</span>
                                        </p>
                                        <p class="text-sm text-slate-500 dark:text-slate-300">{{ option.license_type }} &mdash; {{ option.address }}</p>
                                    </div>
                                </template>
                            </searchable-input>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-slate-50 dark:bg-slate-700 text-right sm:px-6">
                    <button 
                        @click.prevent="saveProducts"
                        type="button"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >Save</button>
                </div>
            </div>
            </form>
        </div>

    </div>
</template>

<script>
import { defineComponent, ref } from 'vue'
import { StreamBarcodeReader } from "vue-barcode-reader";
import { ExclamationIcon } from '@heroicons/vue/solid'
import { VideoCameraIcon, QrcodeIcon,   AcademicCapIcon,
  BadgeCheckIcon,
  CashIcon,
  ClockIcon,
  ReceiptRefundIcon,
  UsersIcon,
  CheckCircleIcon
 } from '@heroicons/vue/outline'

export default defineComponent({
   components: {
        StreamBarcodeReader,
        ExclamationIcon,
        VideoCameraIcon,
        QrcodeIcon,
        AcademicCapIcon,
        BadgeCheckIcon,
        CashIcon,
        ClockIcon,
        ReceiptRefundIcon,
        UsersIcon,
        CheckCircleIcon,
   },
    methods: {
        onDecode(code) {
            code = code.split('|').filter(str => str.startsWith('1A'))[0]?.replace('`', '')
            this.code = code;
        },
        onLoaded() {
            this.loading = false;
        },
        searchForRecalls() {
            this.loading = true;
            this.scan = false;
            axios.post('/api/search', {
                products: this.code?.split(',').map(code => code.trim()).filter(code => code.length),
            })
            .then((res) => {
                this.recalls = res.data;
            })
            .finally(() => {
                this.loading = false;
            })
        },
        saveProducts() {
            console.log(this.decoded)
        },
    },
    watch: {
        code(val, newValue) {
            this.decoded = val.split(',').filter(k => k).map(product_id => ({
                product_id,
                name: null,
                dispensary_id: null,
                grower_id: null,
                tester_id: null,
                strain_id: null,
            }));
        }
    },
    data() {
        return {
            code: '',
            loading: null,
            scan: false,
            decoded: [],
            recalls: [],
        }
    }
})
</script>
