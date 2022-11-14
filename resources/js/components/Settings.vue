<template>
  <div class="h-full">
    <main class="max-w-7xl mx-auto pb-10 lg:py-12 lg:px-8">
      <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">
          <nav class="space-y-1 dark:text-slate-50">
            <a v-for="item in subNavigation" :key="item.name" :href="item.href" 
              :class="[item.current ? 'bg-slate-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-900' : 'text-slate-900 hover:text-slate-900 hover:bg-slate-50 dark:text-slate-50 dark:hover:bg-slate-900 dark:hover:text-slate-200', 'group rounded-md px-3 py-2 flex items-center text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">
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
                      <p class="text-sm font-medium text-slate-900 dark:text-slate-50 truncate">
                      {{ item?.followable?.name }}
                      </p>
                      <p class="text-sm text-slate-500 dark:text-slate-400 truncate">
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
                      <p class="text-sm font-medium text-slate-900 dark:text-slate-50 truncate">
                      {{ item?.likeable?.name }}
                      </p>
                      <p class="text-sm text-slate-500 dark:text-slate-400 truncate">
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
                      <p class="text-sm font-medium text-slate-900 dark:text-slate-50 truncate">
                      {{ item?.favoriteable?.name }}
                      </p>
                      <p class="text-sm text-slate-500 dark:text-slate-400 truncate">
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
          name: 'Account',
          href: '#',
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
