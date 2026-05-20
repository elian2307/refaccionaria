import { api, apiAuth } from './api';

export interface User {
    id: number;
    nombre?: string;
    apellidos?: string | null;
    name?: string;
    email: string;
    rol?: string;
    tipo_usuario?: string;
    created_at?: string;
    updated_at?: string;
}

export interface LoginCredentials {
    email: string;
    password?: string;
}

export interface LoginResponse {
    success?: boolean;
    token: string;
    user: User;
    expires_in?: number;
    msg?: string;
}

const TOKEN_KEY = 'token';
const USER_KEY = 'user';

const OLD_TOKEN_KEY = 'acme_token';
const OLD_USER_KEY = 'acme_user';

export const getToken = (): string | null => {
    return (
        localStorage.getItem(TOKEN_KEY) ||
        sessionStorage.getItem(TOKEN_KEY) ||
        localStorage.getItem(OLD_TOKEN_KEY) ||
        sessionStorage.getItem(OLD_TOKEN_KEY)
    );
};

export const getUser = (): User | null => {
    const userStr =
        localStorage.getItem(USER_KEY) ||
        sessionStorage.getItem(USER_KEY) ||
        localStorage.getItem(OLD_USER_KEY) ||
        sessionStorage.getItem(OLD_USER_KEY);

    if (!userStr) return null;

    try {
        return JSON.parse(userStr);
    } catch (e) {
        console.error('Error al leer el usuario guardado:', e);
        return null;
    }
};

export const isAuthenticated = (): boolean => {
    return !!getToken();
};

export const setSession = (token: string, user: User, remember: boolean = true): void => {
    clearSession();

    if (remember) {
        localStorage.setItem(TOKEN_KEY, token);
        localStorage.setItem(USER_KEY, JSON.stringify(user));
    } else {
        sessionStorage.setItem(TOKEN_KEY, token);
        sessionStorage.setItem(USER_KEY, JSON.stringify(user));
    }
};

export const clearSession = (): void => {
    localStorage.removeItem(TOKEN_KEY);
    localStorage.removeItem(USER_KEY);
    localStorage.removeItem(OLD_TOKEN_KEY);
    localStorage.removeItem(OLD_USER_KEY);

    sessionStorage.removeItem(TOKEN_KEY);
    sessionStorage.removeItem(USER_KEY);
    sessionStorage.removeItem(OLD_TOKEN_KEY);
    sessionStorage.removeItem(OLD_USER_KEY);
};

export const login = async (
    credentials: LoginCredentials,
    remember: boolean = true
): Promise<LoginResponse> => {
    const response = await api.post('/login', credentials);
    const data = response.data as LoginResponse;

    if (data.token && data.user) {
        setSession(data.token, data.user, remember);
    }

    return data;
};

export const logout = async (): Promise<void> => {
    try {
        if (isAuthenticated()) {
            await apiAuth.post('/logout');
        }
    } catch (e) {
        console.error('Error al cerrar sesión:', e);
    } finally {
        clearSession();
    }
};

export const getCurrentUser = async (): Promise<User> => {
    const response = await apiAuth.get('/user');

    const user = response.data.user as User;

    if (localStorage.getItem(TOKEN_KEY)) {
        localStorage.setItem(USER_KEY, JSON.stringify(user));
    } else if (sessionStorage.getItem(TOKEN_KEY)) {
        sessionStorage.setItem(USER_KEY, JSON.stringify(user));
    }

    return user;
};