import axios from "axios";

const apiUrl = import.meta.env.VITE_API_URL;

export const getStoredToken = (): string | null => {
    return (
        localStorage.getItem("token") ||
        sessionStorage.getItem("token") ||
        localStorage.getItem("acme_token") ||
        sessionStorage.getItem("acme_token")
    );
};

export const api = axios.create({
    baseURL: apiUrl,
    headers: {
        "Content-Type": "application/json",
    },
});

export const apiAuth = axios.create({
    baseURL: apiUrl,
    headers: {
        "Content-Type": "application/json",
    },
});

const addAuthHeader = (config: any) => {
    const token = getStoredToken();

    if (token) {
        config.headers = config.headers ?? {};
        config.headers.Authorization = `Bearer ${token}`;
    }

    return config;
};

api.interceptors.request.use(addAuthHeader);
apiAuth.interceptors.request.use(addAuthHeader);