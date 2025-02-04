import axios from 'axios';
import router from '@/router';

const apiClient = axios.create({
    baseURL: 'http://localhost:8000/api/v1',
    headers: { 'Content-Type': 'application/json' },
});

// Авто-добавление токена
apiClient.interceptors.request.use((config) => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

// Авто-выход при 401 (неавторизован)
apiClient.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response && error.response.status === 401) {
            localStorage.removeItem('token');
            router.push('/login');
        }
        return Promise.reject(error);
    }
);

export default {
    register(user) {
        return apiClient.post('/register', user);
    },
    login(credentials) {
        return apiClient.post('/login', credentials);
    },
    logout() {
        return apiClient.get('/logout').finally(() => {
            localStorage.removeItem('token');
            router.push('/login');
        });
    },
    getUser() {
        return apiClient.get('/user');
    },
    updateUser(user) {
        return apiClient.put('/user', user);
    },
    deleteUser() {
        return apiClient.delete('/user');
    },
    getContacts(search = '') {
        return apiClient.get('/contacts', { params: search ? { search } : {} });
    },
    
    addContact(contact) {
        return apiClient.post('/contacts', contact);
    },
    updateContact(id, data) {
        return apiClient.put(`/contacts/${id}`, data);
    },
    deleteContact(id) {
        return apiClient.delete(`/contacts/${id}`);
    },
    searchUsers(query) {
        return apiClient.get('/users/search', { params: { search: query } });
    },

    getUsers(search = '') {
        return apiClient.get('/users', { params: search ? { search } : {} });
    },
    
};
