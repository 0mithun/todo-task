import { defineStore } from "pinia";
import axios from "axios";

export const useUserStore = defineStore("user", {
    state: () => ({
        user: null,
        authenticated: false,
    }),
    actions: {
        async fetchUser() {
            try {
                const res = await axios.get(route('user'));
                this.user = res.data.data;
                this.authenticated = true;
            } catch (error) {
                localStorage.removeItem('token')
                this.authenticated = false;
            }
        },
        setData(data) {
            this.user = data.data;
            localStorage.setItem("token", data.token);
            this.authenticated = true;
        },
    },
});
