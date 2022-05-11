<template>
    <div class="grid grid-cols-4 gap-4 dark:bg-slate-700 overflow-hidden shadow-sm sm:rounded-lg p-4 mt-6">
        <template v-for="recall in $store.getters.recalls" :key="recall.id">
            <div class="text-slate-900 dark:bg-slate-600 dark:text-white py-2 px-2 rounded" >
                <div class="font-bold">
                    <a target="_blank" :href="recall.mra_public_notice_url" v-text="recall.name"></a>
                </div>
                <div>
                    <span v-text="recall.published_at"></span>
                </div>
                <div>Impacted Products <span v-text="recall.products_count"></span></div>
            </div>
        </template>
    </div>
</template>
<script>
import { defineComponent } from 'vue'

export default defineComponent({
    setup() {
        
    },
})
</script>
