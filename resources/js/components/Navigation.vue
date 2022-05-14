<template>
    <Disclosure as="nav" class="bg-slate-800" v-slot="{ open }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="border-b border-slate-700">
            <div class="flex items-center justify-between h-16 px-4 sm:px-0">
              <div class="flex items-center">
                <div class="flex-shrink-0 flex gap-4 flex-wrap items-center">
                  <svg class="fill-current text-white" width="36" height="40" viewBox="0 0 36 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M36 23.373C36 23.373 31.0222 23.0352 26.0946 25.1392C27.0185 24.0481 27.923 22.834 28.7413 21.4895C32.8146 14.789 33.1805 7.53311 33.1805 7.53311C33.1805 7.53311 26.9412 11.1426 22.8664 17.843C22.2674 18.8274 21.7583 19.8228 21.3086 20.8065C21.5832 19.1613 21.7636 17.3958 21.7636 15.5468C21.7636 6.96096 17.9994 0 17.9994 0C17.9994 0 14.2367 6.96096 14.2367 15.547C14.2367 17.3959 14.4172 19.1615 14.6915 20.8061C14.2416 19.8223 13.7313 18.8275 13.1335 17.8431C9.05916 11.1426 2.81952 7.53319 2.81952 7.53319C2.81952 7.53319 3.18568 14.7891 7.25893 21.4896C8.07703 22.8341 8.98162 24.0481 9.90562 25.1393C4.97657 23.0352 0 23.373 0 23.373C0 23.373 3.00898 27.1608 7.95355 29.2878C9.84004 30.0991 11.7343 30.5494 13.3577 30.7989C12.591 30.8562 11.7739 30.9695 10.9418 31.1758C7.34249 32.065 4.84256 34.2898 4.84256 34.2898C4.84256 34.2898 8.17746 35.0715 11.7778 34.1817C14.1117 33.6041 15.9699 32.4732 16.9968 31.7448L16.1373 38.6933C16.0972 39.0234 16.1876 39.3553 16.3873 39.606C16.5871 39.8561 16.8742 40 17.1773 40H18.824C19.1271 40 19.4142 39.8561 19.6141 39.606C19.8139 39.3553 19.904 39.0234 19.8641 38.6933L19.0045 31.7454C20.0316 32.4739 21.8896 33.6041 24.2221 34.1817C27.8225 35.0715 31.1574 34.2898 31.1574 34.2898C31.1574 34.2898 28.6574 32.065 25.0585 31.1758C24.2259 30.9695 23.4088 30.8562 22.6421 30.7989C24.2661 30.5494 26.1604 30.0991 28.0468 29.2878C32.9913 27.1608 36 23.373 36 23.373Z"/>
                  </svg>
                  <span class="text-3xl font-bold text-white">Michigan Cannabis Club</span>
                </div>
                <div class="hidden md:block">
                  <div class="ml-10 flex items-baseline space-x-4">
                    <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-slate-900 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white', 'px-3 py-2 rounded-md text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</a>
                  </div>
                </div>
              </div>
              <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                  <button type="button" class="bg-slate-800 p-1 text-slate-400 rounded-full hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-800 focus:ring-white">
                    <span class="sr-only">View notifications</span>
                    <BellIcon class="h-6 w-6" aria-hidden="true" />
                  </button>
                </div>
              </div>
              <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <DisclosureButton class="bg-slate-800 inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-white hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-800 focus:ring-white">
                  <span class="sr-only">Open main menu</span>
                  <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                  <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
                </DisclosureButton>
              </div>
            </div>
          </div>
        </div>

        <DisclosurePanel class="border-b border-slate-700 md:hidden">
          <div class="px-2 py-3 space-y-1 sm:px-3">
            <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" :class="[item.current ? 'bg-slate-900 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white', 'block px-3 py-2 rounded-md text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>
          </div>
        </DisclosurePanel>
      </Disclosure>
</template>

<script>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { BellIcon, XIcon, MenuIcon } from '@heroicons/vue/outline'
export default {
    components: {
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        BellIcon,
        MenuIcon,
        XIcon,
    },
    name: 'Navigation',
    props: ['user'],
    data () {
        return {
            open: false,
             navigation: [
                { name: 'Recalls', href: '/', current: window.location.pathname === '/' },
                { name: 'Dispensaries', href: '/dispensaries', current: window.location.pathname === '/dispensaries' },
                { name: 'Testers', href: '/testers', current: window.location.pathname === '/testers' },
                { name: 'Growers', href: '/growers', current: window.location.pathname === '/growers' },
            ],

        }
    },
    methods: {
        toggle () {
            this.open = ! this.open
        },
    },
}
</script>