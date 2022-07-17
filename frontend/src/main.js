import { createApp } from "vue";
import App from "./App.vue";

import axios from "axios";

import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";

import LaravelVuePagination from 'laravel-vue-pagination';

import router from "./router";

import store from "./store";

const app = createApp(App)


app.component('Pagination', LaravelVuePagination)






app.use(router)
app.use(store)
app.mount("#app");
