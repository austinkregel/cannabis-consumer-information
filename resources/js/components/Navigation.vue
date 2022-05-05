<template>
    <nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="/dashboard">
                            <application-logo class="block h-10 w-auto fill-current text-gray-600 dark:text-gray-200" />
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <nav-link href="/dashboard">
                            Dashboard
                        </nav-link>

                        <nav-link href="/recalls">
                            Recalls
                        </nav-link>
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <dropdown align="right" width="48">
                        <template slot="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-300 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>{{ $store.getters.user?.name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </template>

                        <template slot="content">
                            <!-- Authentication -->
                            <form method="POST" action="/logout">
                                <dropdown-link href="/logout"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Logout
                                </dropdown-link>
                            </form>
                        </template>
                    </dropdown>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <responsive-nav-link href="/dashboard">
                    Dashboard
                </responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ $store.getters.user?.name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ $store.getters.user?.email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Authentication -->
                    <form method="POST" action="/logout">

                        <responsive-nav-link href="/logout"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            Log Out
                        </responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'Navigation',
    props: ['user'],
    data () {
        return {
            open: false,

        }
    },
    methods: {
        toggle () {
            this.open = ! this.open
        },
    },
}
</script>