require('./bootstrap');
import { createApp } from 'vue'
import store from './store'
import { MailIcon, PhoneIcon } from "@heroicons/vue/outline";

const app = createApp({});
app.use(store);


app.component('mailicon', MailIcon);
app.component('phoneicon', PhoneIcon)
const files = require.context('./components', true, /\.vue$/i);
files.keys().map(key => app.component(key.split('/').pop().split('.')[0], files(key).default));

store.commit('setUser', JSON.parse(document.getElementById('app').getAttribute('data-user')))
store.dispatch('fetchRecalls');

app.mount('#app')
