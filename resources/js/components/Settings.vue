<template>
  <div class="h-full">
    <main class="max-w-7xl mx-auto pb-10 lg:py-12 lg:px-8">
      <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">
          <nav class="space-y-1 dark:text-slate-50">
            <a v-for="item in subNavigation" :key="item.name" :href="item.href"
              :class="[item.current ? 'bg-slate-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-900' : 'text-slate-900 hover:text-slate-900 hover:bg-slate-50 dark:text-slate-50 dark:hover:bg-slate-900 dark:hover:text-slate-200', 'group rounded-md px-3 py-2 flex items-center font-medium']" :aria-current="item.current ? 'page' : undefined">
              <component
                :is="item.icon"
                :class="['flex-shrink-0 -ml-1 mr-3 h-6 w-6']" aria-hidden="true" />
              <span class="truncate">
                {{ item.name }}
              </span>
            </a>
          </nav>
        </aside>
        <div v-if="activeRoute === '/dashboard'" class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
          <div class="text-2xl dark:text-slate-50 text-slate-700">
            Following ({{ $store.getters.user.followings.length }})
          </div>
          <typeable-list :things="$store.getters.user.followings" noThingsMessage="You haven't followed anything.">
            <template v-slot="{ item }">
              <div class="flex items-center space-x-4">
                  <div class="flex-1 min-w-0">
                      <p class="font-medium text-slate-900 dark:text-slate-50 truncate">
                      {{ item?.followable?.name }}
                      </p>
                      <p class="text-slate-500 dark:text-slate-400 truncate">
                      {{ item?.followable?.official_license_type }}
                      </p>
                  </div>
                  <div>
                    <follow-button
                        v-if="$store.getters.user?.id"
                        :type="item.followable_type"
                        :follow="item.followable"
                        class="text-green-600 dark:text-green-400"
                    ></follow-button>
                  </div>
              </div>
            </template>
          </typeable-list>

          <div class="text-2xl dark:text-slate-50 text-slate-700">
            Likes ({{ $store.getters.user.likes.length }})
          </div>
          <typeable-list :things="$store.getters.user.likes" noThingsMessage="You haven't liked anything.">
            <template v-slot="{ item }">
              <div class="flex items-center space-x-4">
                  <div class="flex-1 min-w-0">
                      <p class="font-medium text-slate-900 dark:text-slate-50 truncate">
                      {{ item?.likeable?.name }}
                      </p>
                      <p class="text-slate-500 dark:text-slate-400 truncate">
                      {{ item?.likeable?.official_license_type }}
                      </p>
                  </div>
                  <div>
                    <like-button
                        v-if="$store.getters.user?.id"
                            :type="item.likeable_type"
                            :follow="item.likeable"
                        class="text-blue-600 dark:text-blue-400"
                    ></like-button>
                  </div>
              </div>
            </template>
          </typeable-list>

          <div class="text-2xl dark:text-slate-50 text-slate-700">
            Favorites ({{ $store.getters.user.favorites.length }})
          </div>
          <typeable-list :things="$store.getters.user.favorites" noThingsMessage="You haven't favorited anything.">
            <template v-slot="{ item }">
              <div class="flex items-center space-x-4">
                  <div class="flex-1 min-w-0">
                      <p class="font-medium text-slate-900 dark:text-slate-50 truncate">
                      {{ item?.favoriteable?.name }}
                      </p>
                      <p class="text-slate-500 dark:text-slate-400 truncate">
                      {{ item?.favoriteable?.official_license_type }}
                      </p>
                  </div>
                  <div>
                    <favorite-button
                        v-if="$store.getters.user?.id"
                            :type="item.favoriteable_type"
                            :follow="item.favoriteable"
                        class="text-yellow-600 dark:text-yellow-400"
                    ></favorite-button>
                  </div>
              </div>
            </template>
          </typeable-list>
        </div>
        <div v-else-if="activeRoute === '/products'" class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
          <product-tracker />
        </div>
          <div v-else-if="activeRoute === '/settings'" class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
              <div class="shadow rounded-lg bg-slate-100 dark:bg-slate-800">
                  <form class="divide-y divide-slate-200 dark:divide-slate-800 lg:col-span-9" action="#" method="POST">
                      <!-- Profile section -->
                      <div class="px-4 py-6 sm:p-6 lg:pb-8">
                          <div>
                              <h2 class="text-lg font-medium leading-6 text-slate-900 dark:text-slate-50">Profile</h2>
                              <p class="mt-1 text-slate-500 dark:text-slate-300">This information will be displayed publicly so be careful what you share.</p>
                          </div>

                          <div class="mt-6 flex flex-col lg:flex-row">
                              <div class="flex-grow space-y-6">
                                  <div>
                                      <label for="username" class="block font-medium leading-6 text-slate-900 dark:text-slate-50">Username</label>
                                      <div class="mt-2 flex rounded-md shadow-sm">
                                          <span class="inline-flex items-center rounded-l-md border border-r-0 border-slate-300 dark:border-slate-800 px-3 text-slate-500 dark:text-gray-300 sm:text-sm">workcation.com/</span>
                                          <input type="text" name="username" id="username" autocomplete="username" class="block w-full min-w-0 dark:bg-slate-700 flex-grow rounded-none rounded-r-md border-0 dark:ring-slate-800 py-1.5 text-slate-900 ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:sm:leading-6" :value="user" />
                                      </div>
                                  </div>

                                  <div>
                                      <label for="about" class="block font-medium leading-6 text-slate-900 dark:text-slate-50">About</label>
                                      <div class="mt-2">
                                          <textarea id="about" name="about" rows="3" class="mt-1 block w-full rounded-md border-0 text-slate-900 dark:text-slate-50  shadow-sm ring-1 ring-inset ring-slate-300 dark:ring-slate-800 dark:bg-slate-700 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:py-1.5 sm:sm:leading-6" />
                                      </div>
                                      <p class="mt-2 text-slate-500 dark:text-slate-300">Brief description for your profile. URLs are hyperlinked.</p>
                                  </div>
                              </div>

                              <div class="mt-6 flex-grow lg:ml-6 lg:mt-0 lg:flex-shrink-0 lg:flex-grow-0">
                                  <p class="font-medium leading-6 text-slate-900 dark:text-slate-50" aria-hidden="true">Photo</p>
                                  <div class="mt-2 lg:hidden">
                                      <div class="flex items-center">
                                          <div class="inline-block h-12 w-12 flex-shrink-0 overflow-hidden rounded-full" aria-hidden="true">
                                              <img class="h-full w-full rounded-full" :src="user" alt="" />
                                          </div>
                                          <div class="relative ml-5">
                                              <input id="mobile-user-photo" name="user-photo" type="file" class="peer absolute h-full w-full rounded-md opacity-0" />
                                              <label for="mobile-user-photo" class="pointer-events-none block rounded-md px-3 py-2 font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 dark:ring-slate-900 peer-hover:ring-slate-400 peer-focus:ring-2 peer-focus:ring-sky-500">
                                                  <span>Change</span>
                                                  <span class="sr-only"> user photo</span>
                                              </label>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="relative hidden overflow-hidden rounded-full lg:block">
                                      <img class="relative h-40 w-40 rounded-full" :src="user" alt="" />
                                      <label for="desktop-user-photo" class="absolute inset-0 flex h-full w-full items-center justify-center bg-black bg-opacity-75 font-medium text-white opacity-0 focus-within:opacity-100 hover:opacity-100">
                                          <span>Change</span>
                                          <span class="sr-only"> user photo</span>
                                          <input type="file" id="desktop-user-photo" name="user-photo" class="absolute inset-0 h-full w-full cursor-pointer rounded-md border-slate-300 dark:bg-slate-800 rounded-full opacity-0" />
                                      </label>
                                  </div>
                              </div>
                          </div>

                          <div class="mt-6 grid grid-cols-12 gap-6">
                              <div class="col-span-12 sm:col-span-6">
                                  <label for="first-name" class="block font-medium leading-6 text-slate-900 dark:text-slate-50">First name</label>
                                  <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="dark:bg-slate-700 dark:ring-slate-800 mt-2 block w-full rounded-md border-0 px-3 py-1.5 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:sm:leading-6" />
                              </div>

                              <div class="col-span-12 sm:col-span-6">
                                  <label for="last-name" class="block font-medium leading-6 text-slate-900 dark:text-slate-50">Last name</label>
                                  <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="dark:bg-slate-700 dark:ring-slate-800 mt-2 block w-full rounded-md border-0 px-3 py-1.5 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:sm:leading-6" />
                              </div>

                              <div class="col-span-12">
                                  <label for="url" class="block font-medium leading-6 text-slate-900 dark:text-slate-50">URL</label>
                                  <input type="text" name="url" id="url" class="dark:bg-slate-700 dark:ring-slate-800 mt-2 block w-full rounded-md border-0 px-3 py-1.5 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:sm:leading-6" />
                              </div>

                              <div class="col-span-12 sm:col-span-6">
                                  <label for="company" class="block font-medium leading-6 text-slate-900 dark:text-slate-50">Company</label>
                                  <input type="text" name="company" id="company" autocomplete="organization" class="dark:bg-slate-700 dark:ring-slate-800 mt-2 block w-full rounded-md border-0 px-3 py-1.5 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-sky-500 sm:sm:leading-6" />
                              </div>
                          </div>
                      </div>

                      <!-- Privacy section -->
                      <div class="divide-y divide-slate-200 dark:divide-slate-800 pt-6">
                          <div class="px-4 sm:px-6">
                              <div>
                                  <h2 class="text-lg font-medium leading-6 text-slate-900 dark:text-slate-50">Privacy</h2>
                                  <p class="mt-1 text-slate-500 dark:text-slate-300">Ornare eu a volutpat eget vulputate. Fringilla commodo amet.</p>
                              </div>
                              <ul role="list" class="mt-2 divide-y divide-slate-200 dark:divide-slate-800">
                                  <SwitchGroup as="li" class="flex items-center justify-between py-4">
                                      <div class="flex flex-col">
                                          <SwitchLabel as="p" class="font-medium leading-6 text-slate-900 dark:text-slate-50" passive>Available to hire</SwitchLabel>
                                          <SwitchDescription class="text-slate-500 dark:text-slate-300">Nulla amet tempus sit accumsan. Aliquet turpis sed sit lacinia.</SwitchDescription>
                                      </div>
                                      <Switch v-model="availableToHire" :class="[availableToHire ? 'bg-teal-500 dark:bg-teal-700' : 'bg-slate-200 dark:bg-slate-800' , 'relative ml-4 inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2']">
                                          <span aria-hidden="true" :class="[availableToHire ? 'translate-x-5' : 'translate-x-0', 'inline-block h-5 w-5 transform rounded-full bg-white dark:bg-slate-400 shadow ring-0 transition duration-200 ease-in-out']" />
                                      </Switch>
                                  </SwitchGroup>
                                  <SwitchGroup as="li" class="flex items-center justify-between py-4">
                                      <div class="flex flex-col">
                                          <SwitchLabel as="p" class="font-medium leading-6 text-slate-900 dark:text-slate-50" passive>Available to hire</SwitchLabel>
                                          <SwitchDescription class="text-slate-500 dark:text-slate-300">Nulla amet tempus sit accumsan. Aliquet turpis sed sit lacinia.</SwitchDescription>
                                      </div>
                                      <Switch v-model="availableToHire" :class="[availableToHire ? 'bg-teal-500 dark:bg-teal-700' : 'bg-slate-200 dark:bg-slate-800' , 'relative ml-4 inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2']">
                                          <span aria-hidden="true" :class="[availableToHire ? 'translate-x-5' : 'translate-x-0', 'inline-block h-5 w-5 transform rounded-full bg-white dark:bg-slate-400 shadow ring-0 transition duration-200 ease-in-out']" />
                                      </Switch>
                                  </SwitchGroup>
                                  <SwitchGroup as="li" class="flex items-center justify-between py-4">
                                      <div class="flex flex-col">
                                          <SwitchLabel as="p" class="font-medium leading-6 text-slate-900 dark:text-slate-50" passive>Available to hire</SwitchLabel>
                                          <SwitchDescription class="text-slate-500 dark:text-slate-300">Nulla amet tempus sit accumsan. Aliquet turpis sed sit lacinia.</SwitchDescription>
                                      </div>
                                      <Switch v-model="availableToHire" :class="[availableToHire ? 'bg-teal-500 dark:bg-teal-700' : 'bg-slate-200 dark:bg-slate-800' , 'relative ml-4 inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2']">
                                          <span aria-hidden="true" :class="[availableToHire ? 'translate-x-5' : 'translate-x-0', 'inline-block h-5 w-5 transform rounded-full bg-white dark:bg-slate-400 shadow ring-0 transition duration-200 ease-in-out']" />
                                      </Switch>

                                  </SwitchGroup>
                                  <SwitchGroup as="li" class="flex items-center justify-between py-4">
                                      <div class="flex flex-col">
                                          <SwitchLabel as="p" class="font-medium leading-6 text-slate-900 dark:text-slate-50" passive>Available to hire</SwitchLabel>
                                          <SwitchDescription class="text-slate-500 dark:text-slate-300">Nulla amet tempus sit accumsan. Aliquet turpis sed sit lacinia.</SwitchDescription>
                                      </div>
                                      <Switch v-model="availableToHire" :class="[availableToHire ? 'bg-teal-500 dark:bg-teal-700' : 'bg-slate-200 dark:bg-slate-800' , 'relative ml-4 inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2']">
                                          <span aria-hidden="true" :class="[availableToHire ? 'translate-x-5' : 'translate-x-0', 'inline-block h-5 w-5 transform rounded-full bg-white dark:bg-slate-400 shadow ring-0 transition duration-200 ease-in-out']" />
                                      </Switch>

                                  </SwitchGroup>
                              </ul>
                          </div>
                          <div class="mt-4 flex justify-end gap-x-3 px-4 py-4 sm:px-6 dark:bg-slate-700">
                              <button type="button" class="inline-flex justify-center rounded-md bg-white dark:bg-slate-800 px-3 py-2 font-semibold text-slate-900 dark:text-slate-100 shadow-sm ring-1 ring-inset ring-slate-300 dark:ring-slate-600 hover:bg-slate-50">Cancel</button>
                              <button type="submit" class="inline-flex justify-center rounded-md bg-sky-700 dark:bg-slate-800 px-3 py-2 font-semibold text-white shadow-sm hover:bg-sky-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-700">Save</button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
    </main>
  </div>
</template>

<script>
import {
  BellIcon,
  CogIcon,
  CreditCardIcon,
  KeyIcon,
  MenuIcon,
  UserCircleIcon,
  ViewGridAddIcon,
  FolderAddIcon,
} from '@heroicons/vue/outline'

export default {
  data() {
    return {
        availableToHire: false,
    }
  },
  computed: {
    activeRoute() {
      return window.location.pathname
    },
    subNavigation() {
      return [
        {
          name: 'Dashboard',
          href: '/dashboard',
          icon: UserCircleIcon
        },
        {
          name: 'Product Tracker',
          href: '/products',
          icon: FolderAddIcon
        },
        {
          name: 'Settings',
          href: '/settings',
          icon: CogIcon
        },
      ].map(item => {
        item.current = item.href === this.activeRoute
        return item
      })
    }
  }
}
</script>
