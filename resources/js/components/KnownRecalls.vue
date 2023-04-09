<template>
    <div v-if="$store.getters.recalls?.length > 0" class="grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 gap-4 bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg py-4 px-4 mt-6">
        <template v-for="recall in $store.getters.recalls" :key="recall.id">
            <div class="text-slate-900 bg-slate-100 dark:bg-slate-900 dark:text-white py-2 px-4 rounded shadow">
                <div class="font-semibold tracking-wide text-xl">
                    <a :href="'/recall/' + recall.id" v-text="recall.name"></a>
                </div>

                <div class="flex justify-center gap-12 my-4 text-2xl">
                    <div class="flex items-center justify-center gap-2 "><ShoppingCartIcon class="w-12 h-12 text-slate-100" /> <span v-text="recall.products_count"></span></div>
                    <div class="flex items-center justify-center gap-2"><OfficeBuildingIcon class="w-12 h-12 text-slate-100" /> <span v-text="recall.dispensaries_count"></span></div>
                </div>

                <div class="text-slate-400 dark:text-slate-300">
                   Published <time :datetime="recall.published_at">{{ date(recall.published_at) }}</time>
                </div>
            </div>
        </template>
    </div>
    <div v-else>
        <div class="text-center text-slate-900 dark:bg-slate-800 dark:text-white py-2 px-4 rounded mt-6" >
            <div class="font-bold">
                No recalls found
            </div>
        </div>
    </div>
</template>
<script>
import dayjs from "dayjs";
import {OfficeBuildingIcon, ShoppingCartIcon} from "@heroicons/vue/solid";

export default {
    components: {
        OfficeBuildingIcon,
        ShoppingCartIcon
    },
    methods: {
        date(date) {
            return dayjs(date).format('MMMM D, YYYY');
        },
    },
    mounted() {
    }
}
</script>
