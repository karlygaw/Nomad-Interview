<template>
  <div class="users-view">
    <SideBar />
    <div class="main-content">
      <h1>Users</h1>
      <div class="search-container">
        <input v-model="searchQuery" placeholder="Search users" class="search-input" />
        <span class="search-icon">🔍</span>
      </div>
      <ul class="users-list">
        <li v-for="user in users" :key="user.id" class="user-item">
          <div class="user-info">
            <span class="user-name">{{ user.name }}</span>
            <span class="user-email">{{ user.email }}</span>
          </div>
          <button @click="addContact(user.id)" class="add-button">
            ➕ Add Contact
          </button>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import api from '@/services/api';
import SideBar from '@/components/SideBar.vue'; // Импортируем SideBar

export default {
  components: {
    SideBar, // Регистрируем SideBar
  },
  data() {
    return {
      users: [],
      searchQuery: '',
    };
  },
  watch: {
    searchQuery() {
      this.fetchUsers();
    },
  },
  async created() {
    await this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await api.getUsers(this.searchQuery);
        this.users = response.data?.users || [];
      } catch (error) {
        console.error('Ошибка при загрузке пользователей:', error);
      }
    },
    async addContact(userId) {
      try {
        await api.addContact({ contact_id: userId });
        alert('Contact added successfully!');
        await this.fetchUsers(); // Обновление списка после добавления
      } catch (error) {
        alert('Failed to add contact.');
      }
    },
  },
};
</script>

<style scoped>
.users-view {
  display: flex;
  height: 100vh;
}

.main-content {
  flex: 1;
  padding: 20px;
  background-color: #f5f6fa;
  overflow-y: auto;
}

h1 {
  color: #2c3e50;
  margin-bottom: 20px;
}

.search-container {
  margin-right: 100px;
  position: relative;
  margin-bottom: 20px;
}

.search-input {
  width: 100%;
  padding: 10px 40px 10px 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 14px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.search-input:focus {
  border-color: #42b983;
  box-shadow: 0 2px 8px rgba(66, 185, 131, 0.2);
}

.search-icon {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  color: #888;
}

.users-list {
  margin-right: 40px;
  list-style: none;
  padding: 0;
}

.user-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  margin-bottom: 10px;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.user-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.user-info {
  display: flex;
  flex-direction: column;
}

.user-name {
  font-size: 16px;
  font-weight: bold;
  color: #2c3e50;
}

.user-email {
  font-size: 14px;
  color: #888;
}

.add-button {
  padding: 8px 16px;
  background-color: #42b983;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.3s ease;
}

.add-button:hover {
  background-color: #369f6e;
}
</style>