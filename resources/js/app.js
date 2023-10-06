import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

// Import components
import App from './components/App.vue';
import PropertyList from './components/PropertyList.vue';
import PropertyView from './components/PropertyView.vue';
import PropertyForm from './components/PropertyForm.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', component: PropertyList },
        { path: '/property/create', component: PropertyForm },
        { path: '/property/:id', component: PropertyView },
        { path: '/property/:id/edit', component: PropertyForm },
        { path: '/property/livesearch', component: PropertyList },
    ]
});

const app = createApp(App);
app.use(router);
app.mount('#app');