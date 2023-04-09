<template>
      <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8 mt-6">
        <!-- Replace with your content -->
        <recall-search />
        <div v-if="$store.getters?.recalls?.length > 0" class="grid grid-cols-4 gap-4 dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg py-4 px-4 mt-6">
            <template v-for="recall in $store.getters.recalls" :key="recall.id">
                <div class="text-slate-900 dark:bg-slate-900 dark:text-white py-2 px-4 rounded" >
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


        <div class="mt-8">
            <div class="rounded-lg bg-slate-200 dark:bg-slate-800 overflow-hidden shadow divide-y divide-slate-200 sm:divide-y-0 sm:grid sm:grid-cols-2 sm:gap-px">
              <div v-for="(action, actionIdx) in actions" :key="action.title" :class="[actionIdx === 0 ? 'rounded-tl-lg rounded-tr-lg sm:rounded-tr-none' : '', actionIdx === 1 ? 'sm:rounded-tr-lg' : '', actionIdx === actions.length - 2 ? 'sm:rounded-bl-lg' : '', actionIdx === actions.length - 1 ? 'rounded-bl-lg rounded-br-lg sm:rounded-bl-none' : '', 'relative group bg-white dark:bg-slate-700 p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500']">
                <div>
                  <span :class="[action.iconBackground, action.iconForeground, 'rounded-lg inline-flex p-3 ring-4 ring-white dark:ring-slate-600']">
                    <component :is="action.icon" class="h-6 w-6" aria-hidden="true" />
                  </span>
                </div>
                <div class="mt-8">
                  <h3 class="text-lg font-medium dark:text-slate-200">
                    <a :href="action.href" class="focus:outline-none">
                      <!-- Extend touch target to entire panel -->
                      <span class="absolute inset-0" aria-hidden="true" />
                      {{ action.title }}
                    </a>
                  </h3>
                  <p class="mt-2 text-slate-500 dark:text-slate-50">{{action.description}}</p>
                </div>
                <span class="pointer-events-none absolute top-6 right-6 text-slate-300 group-hover:text-slate-400" aria-hidden="true">
                  <ChevronRightIcon v-if="!action.href.startsWith('http')" class="h-7 w-7" />
                  <ExternalLinkIcon class="w-7 h-7" v-else />
                </span>
              </div>
            </div>
        </div>
        <!-- /End replace -->
      </div>
</template>


<script>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { SearchIcon } from '@heroicons/vue/solid'
import {
  BellIcon,
  MenuIcon,
  XIcon,
  VideoCameraIcon,
  QrcodeIcon,
  AcademicCapIcon,
  BadgeCheckIcon,
  CashIcon,
  ClockIcon,
  ReceiptRefundIcon,
  UsersIcon,
  ExternalLinkIcon,
  ChevronRightIcon,
 } from '@heroicons/vue/outline'

export default {
    components: {
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        SearchIcon,
        BellIcon,
        MenuIcon,
        XIcon,
        VideoCameraIcon,
        QrcodeIcon,
        AcademicCapIcon,
        BadgeCheckIcon,
        CashIcon,
        ClockIcon,
        ReceiptRefundIcon,
        UsersIcon,
        ExternalLinkIcon,
        ChevronRightIcon
    },
    data() {
        return {
            userNavigation: [
                { name: 'Your Profile', href: '#' },
                { name: 'Settings', href: '#' },
                { name: 'Sign out', href: '#' },
            ],
            actions: [
              {
                title: 'Medical Cannabis',
                description: 'Learn about medical regulations of cannabis in the State of Michigan. Including but not limited to growing, selling, and testing cannabis.',
                href: '/medical',
                icon: ClockIcon,
                iconForeground: 'text-teal-700 dark:text-teal-200',
                iconBackground: 'bg-teal-50 dark:bg-teal-700',
              },
              {
                title: 'Recreational Cannabis',
                description: 'Learn about recreational regulations of cannabis in the State of Michigan. Including but not limited to growing, selling, and testing cannabis.',
                href: '/recreation',
                icon: BadgeCheckIcon,
                iconForeground: 'text-purple-700 dark:text-purple-200',
                iconBackground: 'bg-purple-50 dark:bg-purple-700',
              },
              {
                title: 'File a complaint with the MRA',
                description: 'This will take you to michigan.gov/mra to file the complant, from there you\'ll want to click "Enter a Complaint", and then fill out your information.',
                href: 'https://aca-prod.accela.com/MIMM/Cap/CapHome.aspx?SearchType=None&module=Enforcement&TabName=Enforcement&TabList=Home%7C0%7CLicenses%7C1%7CAdult_Use%7C2%7CEnforcement%7C3%7CRegistryCards%7C4%7CCurrentTabIndex%7C3',
                icon: UsersIcon,
                iconForeground: 'text-sky-700 dark:text-sky-200',
                iconBackground: 'bg-sky-50 dark:bg-sky-700',
              },
              {
                title: 'Find a Cannabis Establishment',
                description: 'Michigan publishes the licenses, names, and addresses of all recreational and medical cannabis establishments in the state.',
                href: '/dispensaries',
                icon: CashIcon,
                iconForeground: 'text-yellow-700 dark:text-yellow-200',
                iconBackground: 'bg-yellow-50 dark:bg-yellow-700',
              },
              {
                title: 'Crashcourse in Michigan Cannabis',
                description: 'Traveling to Michigan? New to cannabis? Learn everything you need to know about cannabis in Michigan.',
                href: '/crashcourse',
                icon: ReceiptRefundIcon,
                iconForeground: 'text-rose-700 dark:text-rose-200',
                iconBackground: 'bg-rose-50 dark:bg-rose-700',
              },
              {
                title: 'How does this website get it\'s data?',
                description: 'TLDR: We use the data from published by the state to make this website. We also crowd source some data from other users.',
                href: '/about',
                icon: AcademicCapIcon,
                iconForeground: 'text-indigo-700 dark:text-indigo-200',
                iconBackground: 'bg-indigo-50 dark:bg-indigo-700',
              },
            ]

        }
    }
}
</script>
