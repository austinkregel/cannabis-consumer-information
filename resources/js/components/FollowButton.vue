<template>
    <button @click="doFollow" class="flex items-center gap-2">
        <span v-if="followed || following">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
        </span>
        <span v-else>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
        </span>

        <span v-if="followed || following">unfollow</span>
        <span v-else>follow</span>
    </button>
</template>

<script>
export default {
    props: {
        follow: {
            type: Object,
            default: {
                id: null,
            }
        },
        type: {
            type: String,
            default: 'App\\Models\\Dispensary'
        },
    },
    data() {
        return {
            followed: false
        }
    },
    computed: {
        following() {
            return this.$store.getters.user?.followings?.filter(follow => follow.followable_type === this.type && follow.followable_id === this.follow.id)?.length > 0
        }
    },
    methods: {
        doFollow() {
            this.followed = !this.followed
            this.$store.dispatch('followAFollowableObject', {
                type: this.type,
                id: this.follow.id
            })
        }
    }
}
</script>