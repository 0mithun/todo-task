import './bootstrap';
import { createApp } from 'vue'
import App from './App.vue'
import router from './router/index';
import VueClickAway from "vue3-click-away";
import { createPinia } from "pinia";
import { useUserStore } from './store/user';

const pinia = createPinia();

import mitt from 'mitt';
const emitter = mitt();


const app = createApp(App)
    .use(pinia)
    .use(VueClickAway)
    .provide("emitter", emitter)
    app.config.globalProperties.emitter = emitter;


let userStore
const token = localStorage.getItem("token");
if (token) {
    userStore = useUserStore()
    await userStore.fetchUser()
}



app.use(router)
    .mount("#app")
