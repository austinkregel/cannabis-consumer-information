import './bootstrap';
//
import Alpine from 'alpinejs';

window.Alpine = Alpine;
require('./bootstrap');
import { createApp } from 'vue'
import store from './store'
import { MailIcon, PhoneIcon } from "@heroicons/vue/outline";
import Toaster from '@meforma/vue-toaster';

const app = createApp({});
app.use(store);
app.use(Toaster);
store.commit('setUser', JSON.parse(document.getElementById('app').getAttribute('data-user')))

app.component('mailicon', MailIcon);
app.component('phoneicon', PhoneIcon)
const files = require.context('./components', true, /\.vue$/i);
files.keys().map(key => app.component(key.split('/').pop().split('.')[0], files(key).default));

store.dispatch('fetchRecalls');

app.mount('#app');

window.app = app;
Alpine.start();
