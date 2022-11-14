<template>
    <button @click="like" :class="[loading ? 'animate-wave': '', 'flex items-center gap-2'	]">
        <span v-if="liked || isLiked">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path></svg>
        </span>
        <span v-else>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
        </span>

        <span v-if="liked || isLiked">liked</span>
        <span v-else>like</span>
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
    computed: {
        isLiked() {
            return this.$store.getters.user?.likes?.filter(like => like.likeable_type === this.type && like.likeable_id === this.follow.id)?.length > 0
        }
    },
    data() {
        return {
            liked: false,
            loading: false,
        }
    },
    methods: {
        async like() {
            this.loading = true;
            this.liked = !this.liked
            await this.$store.dispatch('likeALikableObject', {
                type: this.type,
                id: this.follow.id
            });
            this.loading = false;
        }
    }
}
</script>