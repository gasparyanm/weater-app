import axios from "axios";

axios.defaults.withCredentials = true
axios.defaults.baseURL = process.env.VUE_APP_BACKEND_URL;

// Add a response interceptor
axios.interceptors.response.use(function (response) {
    // Do something with response data)
    return response;
}, function (error) {
    // Do something with response error
    return Promise.reject(error);
});

export default axios
