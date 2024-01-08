import './bootstrap';

import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import 'admin-lte/dist/js/adminlte.min.js';

import { createApp } from 'vue/dist/vue.esm-bundler.js';
import { createRouter, createWebHistory } from 'vue-router';
import Routes from './routes.js';
import Login from './pages/auth/login.vue';

const app = createApp({});

const router = createRouter({
    routes: Routes,
    history: createWebHistory(),

});

app.use(router);
app.component('auth-login', Login)
app.mount('#app');


