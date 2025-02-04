<template>
    <div class="login-container">
        <div class="login-box">
            <h1>Login</h1>
            <form @submit.prevent="login" class="login-form">
                <input v-model="email" type="email" placeholder="Email" required class="input-field" />
                <input v-model="password" type="password" placeholder="Password" required class="input-field" />
                <button type="submit" class="login-button">Login</button>
            </form>
            <p class="register-link">
                Don't have an account? <router-link to="/register">Register here</router-link>.
            </p>
        </div>
    </div>
</template>

<script>
import api from '@/services/api';


export default {
    data() {
        return {
            email: '',
            password: '',
        };
    },
    methods: {
        async login() {
            try {
                const response = await api.login({
                    email: this.email,
                    password: this.password,
                });
                localStorage.setItem('token', response.data.token);
                this.$store.dispatch('login'); // Обновляем состояние аутентификации
                this.$router.push('/');
            } catch (error) {
                alert('Login failed');
            }
        },
    },
};
</script>

<style scoped>
/* Стили для контейнера, чтобы форма занимала весь экран */
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
    /* background: linear-gradient(135deg, #6a11cb, #2575fc); */
    padding: 0;
    margin: 0;
}

.login-box {
    background: white;
    padding: 50px;
    border-radius: 12px;
    box-shadow: 0 6px 30px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 500px; /* Максимальная ширина формы */
    text-align: center;
}

h1 {
    margin-bottom: 20px;
    font-size: 26px; /* Заголовок стал крупнее */
    color: #333;
}

.login-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.input-field {
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    width: 100%; /* Ширина полей ввода на всю форму */
}

.login-button {
    padding: 15px;
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 18px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.login-button:hover {
    background: linear-gradient(135deg, #2575fc, #6a11cb);
}

.register-link {
    margin-top: 20px;
    font-size: 16px;
    color: #444;
}

.register-link a {
    color: #6a11cb;
    text-decoration: none;
    font-weight: bold;
}

.register-link a:hover {
    color: #2575fc;
}
</style>
