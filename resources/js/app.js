
import { createApp } from 'vue';
import Articles from './components/Article.vue';
import Navbar from './components/Navbar.vue';

const app = createApp({});
// registers our hello-world component globally
app
    .component('lnavbar', Navbar)
    .component('articles', Articles)
    .mount('#app');

require('./bootstrap');