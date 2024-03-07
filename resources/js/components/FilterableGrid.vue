<template>
    <div>
        <div class="flow-root mt-6 bg-white dark:bg-slate-800 p-4 rounded-lg">
          <div class="w-full h-16 flex items-center mb-6 relative">
            <input @keyup.enter="doSearch" type="text" placeholder="Cannabis Farm" v-model="search" class="pl-2 pr-32 py-2 bg-white dark:bg-slate-700 dark:placeholder-slate-400 dark:text-slate-50 dark:border-slate-600 w-full rounded-lg" />
            <div  class="absolute right-0 flex items-center gap-2 pr-2">
                <Menu as="div" class="relative inline-block text-left">
                    <div>
                    <MenuButton class="inline-flex justify-center w-full rounded-md shadow-sm p-2 bg-white dark:bg-slate-700 font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-100 dark:focus:ring-offset-slate-800 focus:ring-indigo-500">
                        <span class="sr-only">Filter</span>
                        <FilterIcon class="h-5 w-5" aria-hidden="true" />
                    </MenuButton>
                    </div>

                    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                    <MenuItems class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-slate-700 ring-1 ring-black ring-opacity-5 focus:outline-none">
                        <div class="p-4">
                            <SwitchGroup as="div" class="flex items-center">
                                <Switch v-model="show_recreational" :class="[show_recreational ? 'bg-blue-400 dark:bg-blue-600' : 'bg-slate-200 dark:bg-slate-800', 'relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']">
                                    <span aria-hidden="true" :class="[show_recreational ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200']" />
                                </Switch>
                                <SwitchLabel as="span" class="ml-3 flex items-center">
                                    <span v-if="show_recreational" class="font-medium show_recreational text-slate-500 dark:text-slate-400">Recreational </span>
                                    <span v-else class="text-slate-500 dark:text-slate-400">Medical</span>
                                </SwitchLabel>
                            </SwitchGroup>

                            <div class="mt-4">
                                <button @click.prevent="doSearch" class="rounded px-2 py-1 bg-blue-500 dark:bg-slate-800 dark:text-white">Apply</button>
                            </div>
                        </div>

                    </MenuItems>
                    </transition>
                </Menu>
                <button @click.prevent="doSearch" class="rounded px-2 py-1 bg-blue-500 dark:bg-slate-800 dark:text-white">Search</button>
            </div>
          </div>
          <ul role="list" class="-my-5 divide-y divide-slate-200 dark:divide-slate-700 border-t border-slate-200 dark:border-slate-700 ">
            <li class="py-4" v-for="item in displayableItems" :key="item.license_number">
              <slot name="item" :item="item"></slot>
            </li>
            <li v-if="displayableItems.length === 0">
                <div class="text-center py-4 text-slate-500 dark:text-slate-300">No results found</div>
            </li>
          </ul>
        </div>

    </div>
</template>

<script>
import { Menu, MenuButton, MenuItem, MenuItems, Switch, SwitchGroup, SwitchLabel  } from '@headlessui/vue'
import { ChevronDownIcon } from '@heroicons/vue/solid'
import { FilterIcon } from '@heroicons/vue/outline'
import { buildUrl } from "@kbco/query-builder"

export default {
    components: {
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        ChevronDownIcon,
        FilterIcon,
        Switch,
        SwitchGroup,
        SwitchLabel
    },
    props: ['items'],
    data() {
        return {
            displayableItems: [],
            search: '',
            show_recreational: true,
        }
    },
    methods: {
        doSearch() {
            const parameters = Array.from((new URLSearchParams(window.location.search)).entries());
            let params = {};
            for (let index = 0; index < parameters.length; index++) {
                const [queryParam, value] = parameters[index];
                params = {
                    ...params,
                    [queryParam]: value
                }
            }
            params = {
                ...params,
                q: this.search,
                is_recreational: this.show_recreational
            }

            window.location = buildUrl(window.location.pathname, params)
        }
    },
    mounted() {
        const parameters = Array.from((new URLSearchParams(window.location.search)).entries());
        let params = {};
        for (let index = 0; index < parameters.length; index++) {
            const [queryParam, value] = parameters[index];
            params = {
                ...params,
                [queryParam]: value
            }
        }
        this.search = params.q || '';
        this.show_recreational = params.is_recreational || true;
        this.displayableItems = this.items;
    },
}
</script>
