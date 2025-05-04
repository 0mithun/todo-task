import axios from 'axios';
window.axios = axios;


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
// axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
// axios.defaults.baseURL = import.meta.env.VITE_API_URL

axios.interceptors.request.use(config => {
	config.headers['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
	return config;
});

axios.interceptors.response.use(res => {
    return res;
}, (err)=> {
    if(err.response.status == 401){
        if(localStorage.getItem('token')){
            localStorage.removeItem('token')
            window.location = '/'
        }
    }
    return Promise.reject(err);
})
