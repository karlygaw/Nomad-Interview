<template>
    <div class="register-container">
        <div class="register-box">
            <h1>Register</h1>
            <form @submit.prevent="register" class="register-form">
                <input v-model="name" type="text" placeholder="Name" required class="input-field" />
                <input v-model="email" type="email" placeholder="Email" required class="input-field" />
                <input v-model="password" type="password" placeholder="Password" required class="input-field" />
                <input v-model="phone" type="text" placeholder="Phone (optional)" class="input-field" />
                <input v-model="address" type="text" placeholder="Address (optional)" class="input-field" />
                <button type="submit" class="register-button">Register</button>
            </form>
            <p class="login-link">
                Already have an account? <router-link to="/login">Login here</router-link>.
            </p>
        </div>
    </div>
</template>

<script>
import api from '@/services/api';

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            phone: '',
            address: '',
        };
    },
    methods: {
        async register() {
            try {
                const response = await api.register({
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    phone: this.phone,
                    address: this.address,
                });
                localStorage.setItem('token', response.data.token);
                this.$router.push('/');
            } catch (error) {
                alert('Registration failed. Please check your details.');
            }
        },
    },
};
</script>

<style scoped>
.login-container, .register-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.login-box, .register-box {
    background: white;
    padding: 50px;
    border-radius: 12px;
    box-shadow: 0 6px 30px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 500px; /* увеличил максимальную ширину */
    text-align: center;
    animation: fadeIn 0.5s ease-in-out;
}

h1 {
    margin-bottom: 20px;
    font-size: 26px; /* сделал заголовок крупнее */
    color: #333;
}

.login-form, .register-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.input-field {
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    width: 100%; /* Сделал поля ввода шире */
}

.login-button, .register-button {
    padding: 15px;
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 18px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.login-button:hover, .register-button:hover {
    background: linear-gradient(135deg, #2575fc, #6a11cb);
}

.register-link, .login-link {
    margin-top: 20px;
    font-size: 16px;
    color: #444;
}

.register-link a, .login-link a {
    color: #6a11cb;
    text-decoration: none;
    font-weight: bold;
}

.register-link a:hover, .login-link a:hover {
    color: #2575fc;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
