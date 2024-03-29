import axios from "axios";
import store from "./store/index.js";
import router from "./router/index.js";

const axiosClient = axios.create({ baseURL: "http://127.0.0.1:8000/admin" });

axiosClient.interceptors.request.use((config) => {
    config.headers.Authorization = `Bearer ${store.state.user.token}`;
    return config;
});

axiosClient.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        if (error.response.status === 401) {
            sessionStorage.removeItem("TOKEN");
            router.push({ name: "Login" });
        }
        return error;
    }
);

export default axiosClient;
