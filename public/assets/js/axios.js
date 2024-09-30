import axios from "axios";

const axiosInstansce = axios.create({
    baseURL: process.env.VITE_API_BASE_URL,
    timeout: 10000,
    headers: {
        "Content-Type": "application/json",
    },
});

export default axiosInstance;
