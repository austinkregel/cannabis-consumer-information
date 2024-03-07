<template>
    <div>
        <div class="flow-root bg-white dark:bg-slate-800 rounded shadow px-4 py-6">
            <ul role="list" class="-my-5 divide-y divide-slate-200 dark:divide-slate-700">
                <li v-for="thing in things" :key="thing.id" class="py-4">
                    <slot :item="thing">{{ thing }}</slot>
                </li>

                <li v-if="things.length === 0" class="my-4">
                    <div class="italic text-slate-500 dark:text-slate-300">
                        {{ noThingsMessage  }}
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: 'TypeableList',
    props: {
        things: {
            type: Array,
            required: true,
        },
        noThingsMessage: {
            type: String,
            default: 'No items',
        },
    }
}
</script>
