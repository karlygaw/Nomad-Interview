<template>
    <div class="sidebar">
      <div class="logo">Nomad Contacts App</div>
      <ul class="menu">
        <li>
          <router-link to="/" class="menu-item">
            <i class="icon-home"></i>
            <span>My Contacts</span>
          </router-link>
        </li>
        <li>
          <router-link to="/users" class="menu-item">
            <i class="icon-users"></i>
            <span>Users</span>
          </router-link>
        </li>
      </ul>
      <div class="logout">
        <button @click="logout">
          <i class="icon-logout"></i>
          <span>Logout</span>
        </button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    methods: {
      logout() {
        localStorage.removeItem('token');
        this.$router.push('/login');
      },
    },
  };
  </script>
  
  <style scoped>
  .sidebar {
    width: 250px;
    height: 100vh;
    background-color: #1E1E2D;
    color: #fff;
    display: flex;
    flex-direction: column;
    padding: 20px;
    box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
  }
  
  .logo {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 30px;
  }
  
  .menu {
    list-style: none;
    padding: 0;
    flex-grow: 1;
  }
  
  .menu-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px;
    color: #B0B0C3;
    text-decoration: none;
    font-size: 16px;
    border-radius: 8px;
    transition: background 0.3s;
  }
  
  .menu-item:hover {
    background-color: #29293D;
    color: #fff;
  }
  
  .icon-home::before { content: '\1F3E0'; }  /* Иконка дома */
  .icon-users::before { content: '\1F465'; }  /* Иконка пользователей */
  .icon-logout::before { content: '\1F6AA'; } /* Иконка выхода */
  
  .logout button {
    width: 100%;
    padding: 12px;
    background-color: #FF4D4F;
    color: white;
    border: none;
    display: flex;
    align-items: center;
    gap: 15px;
    justify-content: center;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
    margin-bottom: 30px;
  }
  
  .logout button:hover {
    background-color: #E62E2E;
  }
  </style>