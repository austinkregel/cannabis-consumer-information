<template>
    <div class="group relative">
        <div class="absolute right-0 top-0 mt-2 mr-2">
            <button role="button" @click.prevent="() => clearValue()">
                <XIcon class="w-6 h-6 fill-current dark:text-slate-200" /> 
            </button>
        </div>
        <input :value="search" @input="e => doSearch(e.target.value)" type="text" class="dark:text-slate-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-slate-300 dark:border-slate-500 dark:bg-slate-500 rounded-md"/>
        <div v-if="optionsOpen" class="dark:bg-slate-500 bg-white mt-2 rounded shadow">
            <ul role="list" class="divide-y divide-slate-200 dark:divide-slate-600 overflow-y-scroll" style="max-height: 21rem;">
                <li v-for="person in options" :key="person.value" class="py-4">
                    <button class="ml-3 flex flex-col" role="button" @click.prevent="() => updateValue(person)">
                        <slot name="option" :option="person">
                            <div class="flex flex-col gap-1">
                                <p class="text-sm font-medium text-slate-900 dark:text-slate-50 flex items-center gap-2">
                                    <span>{{ person }}</span>
                                </p>
                            </div>
                        </slot>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import { buildUrl } from '@kbco/query-builder'
import {XIcon} from '@heroicons/vue/outline';
export default {
    props: ['modelValue', 'optionMutator', 'url', 'urlOptions'],
    emits: ['update:modelValue'],
    components: { XIcon },
    data() {
        function createDebounce() {
            let timeout = null;
            return function (fnc, delayMs) {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                fnc();
            }, delayMs || 500);
            };
        }

        return {
            page: [],
            loading: true,
            debounce: createDebounce(),
            search: '',
            optionsOpen: true,
        }
    },
    computed: {
        options() {
            return this.page?.data?.map(this.optionMutator ?? ((option) => option)) ?? []
        },
    },
    methods: {
        loadPage() {
            this.loading = true;
            axios.get(buildUrl(this.url, {
                ...this.urlOptions,
                query: this.search,
            })).then(response => {
                this.page = response.data;
            })
            .finally(() => {
                this.loading = false;
            })
        },
        doSearch(searchFor) {
            this.search = searchFor;
            this.debounce(() => {
                this.loadPage()
            }, 250)
        },
        updateValue(person) {
            this.$emit('update:modelValue', (person?.id ?? person?.value));
            this.search = (person?.label ?? person?.name ?? 'No Label, but a value is selected')
            this.optionsOpen = false;
            this.$emit('change', person);
        },
        clearValue() {
            this.$emit('update:modelValue', null)
            this.search = '';
            this.optionsOpen = true;
        }
    },
    mounted() {
        this.search = this.modelValue;
        this.loadPage();
    }
}
</script>