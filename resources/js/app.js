import './bootstrap';
import { createApp } from 'vue'
import mixin from './mixins/mixin'
import App from './App.vue'
import router from './router/index';
import VueClickAway from "vue3-click-away";
import { createPinia } from "pinia";
import { useUserStore } from './store/user';

const pinia = createPinia();


const app = createApp(App)
    .use(pinia)
    .mixin(mixin)
    .use(VueClickAway)

let userStore
const token = localStorage.getItem("token");
if (token) {
    userStore = useUserStore()
    await userStore.fetchUser()
}



app.use(router)
    .mount("#app")
