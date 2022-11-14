<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div class="flow-root max-w-3xl mx-auto">
    <div class="h-64 flex flex-col gap-3 text-left">
      <div class="flex items-center gap-3 text-black dark:text-slate-300">
        <span :class="[
            'bg-fuchsia-500 dark:bg-fuchsia-600',
            'h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white dark:ring-slate-600'
            ]">
          <ActivityFeedIcons :activity="'released'" class="h-6 w-6 text-white" aria-hidden="true" />
        </span>
        <span class="flex-1">Released</span>
      </div>
      <div class="flex items-center gap-3 text-black dark:text-slate-300">
        <span :class="[
            'bg-yellow-500 dark:bg-yellow-600',  
            'h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white dark:ring-slate-600'
            ]">
          <ActivityFeedIcons :activity="'recall'" class="h-6 w-6 text-white" aria-hidden="true" />
        </span>
        <span>Recall</span>
      </div>
      <div class="flex items-center gap-3 text-black dark:text-slate-300">
        <span :class="[
            'bg-sky-500 dark:bg-sky-600',
            'h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white dark:ring-slate-600'
            ]">
          <ActivityFeedIcons :activity="'created'" class="h-6 w-6 text-white" aria-hidden="true" />
        </span>
        <span>Created</span>
      </div>
      <div class="flex items-center gap-3 text-black dark:text-slate-300">
        <span :class="[
            'bg-green-500 dark:bg-green-600',
            'h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white dark:ring-slate-600'
            ]">
          <ActivityFeedIcons :activity="'updated'" class="h-6 w-6 text-white" aria-hidden="true" />
        </span>
        <span>Updated</span>
      </div>
      <div class="flex items-center gap-3 text-black dark:text-slate-300">
        <span :class="[
            'bg-red-500 dark:bg-red-600',
            'h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white dark:ring-slate-600'
            ]">
          <ActivityFeedIcons :activity="'deleted'" class="h-6 w-6 text-white" aria-hidden="true" />
        </span>
        <span>Deleted</span>
      </div>
    </div>
    <ul role="list" class="-mb-8">
      <li v-for="(event, eventIdx) in data" :key="event.id">
        <div class="relative pb-8">
          <span v-if="eventIdx !== data.length - 1" class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-200 dark:bg-slate-700" aria-hidden="true" />
          <div class="relative flex space-x-3">
            <div>
              <span :class="[
                  activityLogSimplifier(event) === 'released' ? 'bg-fuchsia-500 dark:bg-fuchsia-600' :'',  
                  activityLogSimplifier(event) === 'recall' ? 'bg-yellow-500 dark:bg-yellow-600' :'',  
                  activityLogSimplifier(event) === 'created' ? 'bg-sky-500 dark:bg-sky-600': '',
                  activityLogSimplifier(event) === 'updated' ? 'bg-green-500 dark:bg-green-600': '',
                  activityLogSimplifier(event) === 'deleted' ? 'bg-red-500 dark:bg-red-600': '',
                  'h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white dark:ring-slate-600'
                  ]">
                <ActivityFeedIcons :activity="activityLogSimplifier(event)" class="h-6 w-6 text-white" aria-hidden="true" />
              </span>
            </div>
            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
              <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                  <a v-if="event.causer && event.causer_type === 'App\\Models\\Recall'" :href="'/recall/'+event.causer.id" class="font-medium text-slate-900 dark:text-slate-100">{{ event.causer.name }}</a>
                  <span v-else-if="event.causer" class="font-medium text-slate-900 dark:text-slate-100">{{ event.causer.name }}</span>
                  {{ activityLogSimplifier(event) }} 
                  <a v-if="event.subject && event.subject_type === 'App\\Models\\Dispensary'"  :href="'/dispensary/'+event.subject.license_number" class="d font-medium text-slate-900 dark:text-slate-100">{{ event.subject?.name }}</a>
                  <span v-else-if="event.subject && event.subject_type !== 'App\\Models\\Product'" class="a font-medium text-slate-900 dark:text-slate-100">{{ event.subject?.product_id ?? event.subject?.name ?? event.subject }}</span>
                  <span v-else-if="event.subject" class="s font-medium text-slate-900 dark:text-slate-100">{{ event.subject }}</span>
                </p>
              </div>
              <div class="text-right text-sm whitespace-nowrap text-slate-500 dark:text-slate-400">
                <time :datetime="event.date">{{ date(event.date) }}</time>
              </div>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>

import { CheckIcon, ThumbUpIcon, UserIcon } from '@heroicons/vue/solid'
import dayjs from 'dayjs';
import ActivityFeedIcons from './ActivityFeedIcons.vue';

export default {
    components: {
    UserIcon,
    ActivityFeedIcons
},
    data () {
        return {
            feed: null,
            timeline: [
  {
    id: 1,
    content: 'Applied to',
    target: 'Front End Developer',
    href: '#',
    date: 'Sep 20',
    datetime: '2020-09-20',
    icon: UserIcon,
    iconBackground: 'bg-slate-400',
  },
  {
    id: 2,
    content: 'Advanced to phone screening by',
    target: 'Bethany Blake',
    href: '#',
    date: 'Sep 22',
    datetime: '2020-09-22',
    icon: ThumbUpIcon,
    iconBackground: 'bg-blue-500',
  },
  {
    id: 3,
    content: 'Completed phone screening with',
    target: 'Martha Gardner',
    href: '#',
    date: 'Sep 28',
    datetime: '2020-09-28',
    icon: CheckIcon,
    iconBackground: 'bg-green-500',
  },
  {
    id: 4,
    content: 'Advanced to interview by',
    target: 'Bethany Blake',
    href: '#',
    date: 'Sep 30',
    datetime: '2020-09-30',
    icon: ThumbUpIcon,
    iconBackground: 'bg-blue-500',
  },
  {
    id: 5,
    content: 'Completed interview with',
    target: 'Katherine Snyder',
    href: '#',
    date: 'Oct 4',
    datetime: '2020-10-04',
    icon: CheckIcon,
    iconBackground: 'bg-green-500',
  },
],
activityLogSimplifier
        }
    },

    computed: {
        data() {
            return (this.feed?.data ?? []).map(activityLog => {
                return {
                    type: 'recall',
                    description: activityLog.description,
                    causer: activityLog.causer,
                    date: dayjs(activityLog.created_at),
                    subject: activityLog.subject,
                }
            })
            .concat(this.$store.getters.recalls.map(recall => {
                return {
                    type: 'recall',
                    description: 'released',
                    causer: {
                        name: "Michigan CRA",
                    },
                    date: dayjs(recall.published_at),
                    subject: recall
                }
            }))
            .sort((a, b) => {
                return dayjs(b.date).unix() 
                     - dayjs(a.date).unix();
            });
        }
    },

    methods: {
        // subject to readable
        readable (activity) {
            const parts = activity?.split('\\') ?? [];
            return parts[parts.length - 1];
        },
        date(date) {
            return dayjs(date).format('MMMM D, YYYY');
        },
    
    },

    mounted() {
        axios.get('/api/feed').then(response => {
            this.feed = response.data;
        });
    }
}
</script>