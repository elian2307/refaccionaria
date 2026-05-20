import { api, apiAuth } from './api';

export interface User {
  id: number;
  name: string;
  email: string;
  created_at?: string;
  updated_at?: string;
}

export interface LoginCredentials {
  email: string;
  password?: string;
}

export interface LoginResponse {
  token: string;
  user: User;
  expires_in?: number;
}

const TOKEN_KEY = 'acme_token';
const USER_KEY = 'acme_user';

/**
 * Gets the token from localStorage or sessionStorage.
 */
export const getToken = (): string | null => {
  return localStorage.getItem(TOKEN_KEY) || sessionStorage.getItem(TOKEN_KEY);
};

/**
 * Gets the current user from localStorage or sessionStorage.
 */
export const getUser = (): User | null => {
  const userStr = localStorage.getItem(USER_KEY) || sessionStorage.getItem(USER_KEY);
  if (!userStr) return null;
  try {
    return JSON.parse(userStr);
  } catch (e) {
    console.error('Failed to parse stored user:', e);
    return null;
  }
};

/**
 * Checks if a token is present in storage.
 */
export const isAuthenticated = (): boolean => {
  return !!getToken();
};

/**
 * Sets the active session in either localStorage or sessionStorage.
 */
export const setSession = (token: string, user: User, remember: boolean): void => {
  if (remember) {
    localStorage.setItem(TOKEN_KEY, token);
    localStorage.setItem(USER_KEY, JSON.stringify(user));
    // Clean up sessionStorage to prevent session duplicates
    sessionStorage.removeItem(TOKEN_KEY);
    sessionStorage.removeItem(USER_KEY);
  } else {
    sessionStorage.setItem(TOKEN_KEY, token);
    sessionStorage.setItem(USER_KEY, JSON.stringify(user));
    // Clean up localStorage to prevent persistent duplicates
    localStorage.removeItem(TOKEN_KEY);
    localStorage.removeItem(USER_KEY);
  }
};

/**
 * Clears the session from both storages.
 */
export const clearSession = (): void => {
  localStorage.removeItem(TOKEN_KEY);
  localStorage.removeItem(USER_KEY);
  sessionStorage.removeItem(TOKEN_KEY);
  sessionStorage.removeItem(USER_KEY);
};

/**
 * Performs a login request to the Laravel backend.
 */
export const login = async (credentials: LoginCredentials, remember: boolean = false): Promise<LoginResponse> => {
  const response = await api.post('/login', credentials);
  const data = response.data as LoginResponse;
  
  if (data.token && data.user) {
    setSession(data.token, data.user, remember);
  }
  return data;
};

/**
 * Performs a logout request and clears all frontend sessions.
 */
export const logout = async (): Promise<void> => {
  try {
    if (isAuthenticated()) {
      await apiAuth.post('/logout');
    }
  } catch (e) {
    console.error('Logout request failed:', e);
  } finally {
    clearSession();
  }
};

/**
 * Fetches the current authenticated user's details and updates the storage.
 */
export const getCurrentUser = async (): Promise<User> => {
  const response = await apiAuth.get('/user');
  const user = response.data as User;
  
  // Update user in whichever storage it currently exists in
  if (localStorage.getItem(TOKEN_KEY)) {
    localStorage.setItem(USER_KEY, JSON.stringify(user));
  } else if (sessionStorage.getItem(TOKEN_KEY)) {
    sessionStorage.setItem(USER_KEY, JSON.stringify(user));
  }
  
  return user;
};