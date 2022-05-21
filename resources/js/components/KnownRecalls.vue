<template>
    <div v-if="$store.getters.recalls?.length > 0" class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-4 dark:bg-slate-700 overflow-hidden shadow-sm sm:rounded-lg py-4 px-4 mt-6">
        <template v-for="recall in $store.getters.recalls" :key="recall.id">
            <div class="text-slate-900 dark:bg-slate-600 dark:text-white py-2 px-4 rounded" >
                <div class="font-bold">
                    <a :href="'/recall/' + recall.id" v-text="recall.name"></a>
                </div>
                <div>
                    <span v-text="recall.published_at"></span>
                </div>
                <div>Impacted Products <span v-text="recall.products_count"></span></div>
                <div>Impacted Facilities <span v-text="recall.dispensaries_count"></span></div>
            </div>
        </template>
    </div>
    <div v-else>
        <div class="text-center text-slate-900 dark:bg-slate-600 dark:text-white py-2 px-4 rounded mt-6" >
            <div class="font-bold">
                No recalls found
            </div>
        </div>
    </div>
</template>
<script>
export default {
    mounted() {
    }
}
</script>
