<template>
  <div id="app">
    <NavBar />
    <div class="app-container">
      <div class="main-content">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script>

export default {
  computed: {
      isAuthenticated() {
          return !!localStorage.getItem('token');
      },
  },
};
</script>

<style>
/* Убираем все отступы и заполняем всю страницу */
html, body, #app {
  width: 100%;
  height: 100vh;
  margin: 0;
  padding: 0;
  overflow: hidden;
}

/* Контейнер для всего содержимого */
.app-container {
  display: flex;
  height: 100vh;
  flex-direction: row;
}

.main-content {
  width: 100%;
  height: 100vh;
  margin: 0;
  padding: 0;
  overflow: hidden;
  flex: 1;
  overflow-y: auto;
}
</style>