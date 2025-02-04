<template>
  <div class="home-view">
    <SideBar />
    <div class="main-content">
      <div class="main-2">
      <h1>My Contacts</h1>
      <div class="search-container">
        <input v-model="searchQuery" @input="fetchContacts" placeholder="Search contacts" class="search-input" />
        <span class="search-icon">🔍</span>
      </div>
      <ul class="contacts-list">
        <li v-for="contact in contacts" :key="contact.id" class="contact-item">
          <div class="contact-info">
            <div class="contact-line">
              <span class="emoji">👤</span>
              <span class="label">Nickname:</span>
              <span class="value">{{ contact.nickname || 'No nickname' }}</span>
            </div>
            <div class="contact-line">
              <span class="emoji">📝</span>
              <span class="label">Full Name:</span>
              <span class="value">{{ contact.contact_user?.name || 'Unknown' }}</span>
            </div>
            <div class="contact-line">
              <span class="emoji">📧</span>
              <span class="label">Email:</span>
              <span class="value">{{ contact.contact_user?.email || 'No email' }}</span>
            </div>
          </div>
          <div class="contact-actions">
            <button @click="openEditModal(contact)" class="edit-button">
              ✏️
            </button>
            <button @click="deleteContact(contact.id)" class="delete-button">
              🗑️
            </button>
          </div>
        </li>
      </ul>
      <p v-if="contacts.length === 0" class="no-contacts">No contacts found</p>

      <!-- Модальное окно для редактирования псевдонима -->
      <div v-if="isEditModalOpen" class="modal-overlay">
        <div class="modal-content">
          <h2>Edit Nickname</h2>
          <input v-model="editNickname" placeholder="New nickname" class="modal-input" />
          <div class="modal-actions">
            <button @click="closeEditModal" class="modal-button cancel">Cancel</button>
            <button @click="updateNickname" class="modal-button save">Save</button>
          </div>
        </div>
      </div>
    </div>
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
      contacts: [],
      searchQuery: '',
      isEditModalOpen: false,
      editNickname: '',
      selectedContact: null,
    };
  },
  async created() {
    await this.fetchContacts();
  },
  methods: {
    async fetchContacts() {
      try {
        const response = await api.getContacts(this.searchQuery);
        this.contacts = response.data?.data || [];
      } catch (error) {
        console.error('Ошибка при загрузке контактов:', error);
      }
    },
    async deleteContact(id) {
      try {
        await api.deleteContact(id);
        this.contacts = this.contacts.filter(contact => contact.id !== id);
      } catch (error) {
        console.error('Ошибка при удалении контакта:', error);
      }
    },
    openEditModal(contact) {
      this.selectedContact = contact;
      this.editNickname = contact.nickname || '';
      this.isEditModalOpen = true;
    },
    closeEditModal() {
      this.isEditModalOpen = false;
      this.selectedContact = null;
      this.editNickname = '';
    },
    async updateNickname() {
      if (this.selectedContact) {
        try {
          const data = {
            nickname: this.editNickname,
          };

          const response = await api.updateContact(this.selectedContact.id, data);
          console.log('Ответ сервера:', response); // Выводим ответ сервера

          this.selectedContact.nickname = this.editNickname;
          this.closeEditModal();
        } catch (error) {
          console.error('Ошибка при обновлении псевдонима:', error.response?.data || error.message);
        }
      }
    },
  },
};
</script>

<style scoped>
.home-view {
  width: 100%;
  height: 100vh;
  margin: 0;
  overflow: hidden;
  display: flex;
}

.main-2 {
  margin-left: 30px;
}


.main-content {
  flex: 1;
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
  right: 0px;
  top: 50%;
  transform: translateY(-50%);
  color: #888;
}

.contacts-list {
  margin-right: 40px;
  list-style: none;
  padding: 0;
}

.contact-item {
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

.contact-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.contact-info {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.contact-line {
  display: flex;
  align-items: center;
  gap: 8px;
}

.emoji {
  font-size: 16px;
}

.label {
  font-size: 14px;
  color: #666;
}

.value {
  font-size: 14px;
  font-weight: bold;
  color: #2c3e50;
}

.contact-actions {
  display: flex;
  gap: 10px;
}

.edit-button,
.delete-button {
  background: none;
  border: none;
  font-size: 18px;
  cursor: pointer;
  transition: color 0.3s ease;
}

.edit-button {
  color: #42b983;
}

.edit-button:hover {
  color: #2c3e50;
}

.delete-button {
  color: #ff4d4d;
}

.delete-button:hover {
  color: #e62e2e;
}

.no-contacts {
  text-align: center;
  color: #888;
  font-size: 14px;
  margin-top: 20px;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  width: 300px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.modal-input {
  width: 100%;
  padding: 10px;
  margin-top: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
}

.modal-actions {
  display: flex;
  justify-content: flex-end;
  margin-top: 20px;
}

.modal-button {
  padding: 8px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  margin-left: 10px;
}

.modal-button.cancel {
  background-color: #ddd;
  color: #333;
}

.modal-button.save {
  background-color: #42b983;
  color: white;
}

.modal-button.save:hover {
  background-color: #2c3e50;
}
</style>