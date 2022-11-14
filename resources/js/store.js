import { createStore } from "vuex";

export default createStore({
    state: {
        user: {},
        recalls: [],
        products: [],
        dispensaries: [],
    },
    getters: {
        recalls: state => state.recalls,
        products: state => state.products,
        dispensaries: state => state.dispensaries,
        user: state => state.user ?? {},
    },
    mutations: {
        setRecalls(state, payload) {
            state.recalls = payload;
        },
        setUser(state, user) {
            state.user = user;
        }
    },
    actions: {
        async fetchUser({ commit }) {
            const response = await axios.get('/api/user');
            commit('setUser', response.data);
        },
        async fetchRecalls({ commit }) {
            const response = await axios.get('/api/recalls');
            commit('setRecalls', response.data);
        },
        async fetchProducts({ commit }) {
            const response = await axios.get('/api/products');
            commit('setProducts', response.data);
        },
        async fetchDispensaries({ commit }) {
            const response = await axios.get('/api/dispensaries');
            commit('setDispensaries', response.data);
        },
        async likeALikableObject({ commit, dispatch }, payload) {
            try {
                const response = await axios.post('/api/like', {
                    likeable_type: payload.type,
                    likeable_id: payload.id,
                });
            } catch (error) {
                if (error.response.data.message) {
                    app.$toast.error(error.response.data.message);
                } else {
                    app.$toast.error(error.message);
                }
            } finally {
                await dispatch('fetchUser');
            }
        },
        async followAFollowableObject({ commit, dispatch }, payload) {
            try {
                const response = await axios.post('/api/follow', {
                    followable_type: payload.type,
                    followable_id: payload.id,
                });
            } catch (error) {
                if (error.response.data.message) {
                    app.$toast.error(error.response.data.message);
                } else {
                    app.$toast.error(error.message);
                }
            } finally {
                await dispatch('fetchUser');
            }
        },
        async favoriteAFavoritableObject({ commit, dispatch }, payload) {
            try {
                const response = await axios.post('/api/favorite', {
                    favoriteable_type: payload.type,
                    favoriteable_id: payload.id,
                });
            } catch (error) {
                if (error.response.data.message) {
                    app.$toast.error(error.response.data.message);
                } else {
                    app.$toast.error(error.message);
                }
            } finally {
                await dispatch('fetchUser');
            }
        },
    }
})