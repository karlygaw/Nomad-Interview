import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store'; // Импортируем хранилище

createApp(App).use(router).use(store).mount('#app');