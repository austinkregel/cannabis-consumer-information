require('./bootstrap');
import { createApp } from 'vue'
import store from './store'

const app = createApp({});
app.use(store);

const files = require.context('./components', true, /\.vue$/i);
files.keys().map(key => app.component(key.split('/').pop().split('.')[0], files(key).default));

store.commit('setUser', JSON.parse(document.getElementById('app').getAttribute('data-user')))
store.dispatch('fetchRecalls');

app.mount('#app')
