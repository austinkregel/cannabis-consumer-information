<template>
    <div>
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow px-5 py-6 sm:px-6">
          <div>
            <label for="dispensary_name" class="block text-md font-medium text-slate-700 dark:text-slate-300">Dispensary Name/License Number</label>
            <div class="mt-1 flex rounded-md shadow-sm">
              <div class="relative flex items-stretch flex-grow focus-within:z-10">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <QrcodeIcon class="h-5 w-5 text-slate-400 dark:text-slate-100" aria-hidden="true" />
                </div>
                <input v-model="code" type="dispensary_name" name="dispensary_name" id="dispensary_name" class="dark:text-slate-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none rounded-l-md pl-10 sm:border-slate-300 dark:border-slate-500 dark:bg-slate-800" placeholder="1A40530000..., 1A405..." />
              </div>
              <button @click="scan = !scan" type="button" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-slate-300 dark:border-slate-700 font-medium rounded-r-md text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                <VideoCameraIcon class="fill-current h-5 w-5 text-slate-400 dark:text-slate-200" aria-hidden="true" />
                <span>Scan</span>
              </button>
            </div>

              <button @click="searchForRecalls" type="button" class="-ml-px mt-2 relative inline-flex items-center space-x-2 px-4 py-2 border border-slate-300 dark:border-slate-700 font-medium rounded-md text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                <span>Search</span>
              </button>
            </div>

            <div v-if="scan" class="flex flex-wrap justify-center w-full bg-slate-800">
                <div class="max-w-xl">
                    <StreamBarcodeReader @decode="onDecode" @loaded="onLoaded"></StreamBarcodeReader>
                    <div class="text-white text-center">You can scan as many products as you'd like.</div>
                </div>
            </div>
        </div>

        <div v-if="recalls.length > 0" class="flex flex-col gap-4 bg-white dark:bg-slate-700 overflow-hidden shadow-sm sm:rounded-lg p-4 mt-6">
            <div class="text-slate-900 dark:text-slate-300">
                <div v-for="recall in recalls" :key="recall.id">
                    <div class="rounded-md bg-yellow-50 dark:bg-yellow-700 p-4">
                        <div class="flex flex-col">
                            <div class="flex-shrink-0 flex items-center">
                                <ExclamationIcon class="mr-1 h-5 w-5 text-yellow-400" aria-hidden="true" />
                                <a target="_blanket" class="font-medium text-yellow-800 dark:text-yellow-50 underline" :href="recall.mra_public_notice_url">{{recall.name}}</a>
                            </div>
                            <div class="ml-6">
                                <div class="mt-2 text-yellow-700 dark:text-yellow-50">
                                    <p v-for="product in recall.products" :key="product.id">{{product.name}} <span v-if="product.name">&mdash;</span> {{product.id}}</p>
                                </div>
                                <div class="w-full text-yellow-700 dark:text-yellow-50 mt-2 text-sm">Published {{recall.pretty_published_at}}</div>
                            </div>
                            <div class="ml-6">
                                <a target="_blanket" class="font-medium text-yellow-800 dark:text-yellow-50 underline" :href="recall.mra_public_notice_url">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


          <div class="rounded-md bg-green-50 dark:bg-teal-700 p-4 mt-6"  v-if="!loading && !scan && code && recalls.length === 0">
            <div class="flex flex-col">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <CheckCircleIcon class="h-6 w-6 text-green-400 dark:text-teal-300" aria-hidden="true" />
                    <h3 class="font-medium text-green-800  dark:text-teal-100">This product is not recalled according to our records</h3>
                </div>
                <div class="ml-8">
                    <div class="mt-2 text-green-700  dark:text-teal-50">
                        <p>We've emailed the CRA to try and gain access to vendor information like which dispensary sold the product, who grew the product, who tested the product, and any related test results. This information should be made public, to allow any consumer or third party (like Michigan Cannabis Club) to audit the labels on the products they buy.</p>
                    </div>
                    <div class="mt-2 text-green-700 dark:text-teal-50">
                        Please understand that since information about the products are not public, we <b class="font-bold">cannot guarantee</b> that your product wasn't <a href="https://www.michigan.gov/mra/-/media/Project/Websites/mra/bulletin/1Public-Health-an-Safety-Advisory/111821_Notification_of_Marijuana_Product_Recall_Viridis_Bulletin_Update_741566_7.pdf?rev=17c593bdbd564a1ca1cf589fafdec38b&amp;hash=7CAD5E5B5FBB087652A0E2BCF7F61F65">tested by Viridis Laboratories, LLC, or Viridis North, LLC between August 10th, 2021, and November 16th, 2021</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
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

export default {
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
        }
    }
}
</script>
