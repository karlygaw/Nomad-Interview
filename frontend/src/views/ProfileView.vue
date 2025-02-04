<template>
    <div class="main-content">
        <h1>Profile</h1>
        <div v-if="user" class="profile-details">
            <div class="profile-info">
                <p><strong>Name:</strong> {{ user.name }}</p>
                <p><strong>Email:</strong> {{ user.email }}</p>
                <p><strong>Phone:</strong> {{ user.phone || 'Not provided' }}</p>
                <p><strong>Address:</strong> {{ user.address || 'Not provided' }}</p>
            </div>

            <h2>Edit Profile</h2>
            <form @submit.prevent="updateProfile" class="edit-form">
                <input v-model="editName" type="text" placeholder="Name" required />
                <input v-model="editEmail" type="email" placeholder="Email" required />
                <input v-model="editPhone" type="text" placeholder="Phone (optional)" />
                <input v-model="editAddress" type="text" placeholder="Address (optional)" />
                <button type="submit">Update Profile</button>
            </form>
        </div>
        <p v-else>Loading profile...</p>
    </div>
</template>

<script>
import api from '@/services/api';

export default {
    data() {
        return {
            user: null,
            editName: '',
            editEmail: '',
            editPhone: '',
            editAddress: '',
        };
    },
    async created() {
        await this.fetchUserProfile();
    },
    methods: {
        async fetchUserProfile() {
            try {
                const response = await api.getUser();
                this.user = response.data;
                this.editName = this.user.name;
                this.editEmail = this.user.email;
                this.editPhone = this.user.phone;
                this.editAddress = this.user.address;
            } catch (error) {
                alert('Failed to fetch profile data.');
            }
        },
        async updateProfile() {
            try {
                const updatedUser = {
                    name: this.editName,
                    email: this.editEmail,
                    phone: this.editPhone,
                    address: this.editAddress,
                };
                const response = await api.updateUser(updatedUser);
                this.user = response.data.user;
                alert('Profile updated successfully!');
            } catch (error) {
                alert('Failed to update profile.');
            }
        },
    },
};
</script>

<style scoped>
.main-content {
    flex: 1;
    padding: 20px;
}

.profile-details {
    margin-top: 20px;
}

.profile-info p {
    margin-bottom: 10px;
    font-size: 16px;
}

.edit-form {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 20px;
}

.edit-form input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

.edit-form button {
    padding: 10px;
    background-color: #42b983;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.edit-form button:hover {
    background-color: #369f6e;
}
</style>