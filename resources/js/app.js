require('./bootstrap');
import { createApp } from 'vue'
import Recall from './Pages/Recall.vue';
import KnownRecalls from './components/KnownRecalls.vue';
import RecallSearch from './components/RecallSearch.vue';
import store from './store'

const app = createApp({});
app.use(store);

app.component('recall', Recall);
app.component('known-recalls', KnownRecalls);
app.component('recall-search', RecallSearch);

app.mount('#app')
