<template>
    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <recall-search></recall-search>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <div class="text-3xl text-slate-900 dark:text-slate-50 py-2 px-4">
                    Known recalls
                </div>
            </div>
            <known-recalls></known-recalls>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        recalls: {
            type: Array,
            required: true,
        },
    },
    mounted() {
        this.$store.commit('setRecalls', this.recalls);
    }
}
</script>
