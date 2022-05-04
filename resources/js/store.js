import { createStore } from "vuex";

export default createStore({
    state: {
        recalls: [],
        products: [],
        dispensaries: [],
    },
    getters: {
        recalls: state => state.recalls,
        products: state => state.products,
        dispensaries: state => state.dispensaries,
    },
    mutations: {
        setRecalls(state, payload) {
            state.recalls = payload;
        }
    },
    actions: {
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
    }
})