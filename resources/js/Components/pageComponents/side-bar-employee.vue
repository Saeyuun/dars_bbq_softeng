<template>
  <div class="sidebar-container">
    <h1>Dar's BBQ</h1>
    <div class="profile-section">
      <img
        src="../assets/profile-image.png"
        class="profile-pic"
        alt="Profile Picture"
      />
      <p class="profile-name">Karina</p>
      <p class="profile-role">Employee</p>
    </div>
    <nav class="nav-links">
      <a href="#" class="home">Home</a>
      <a href="#" class="nav-link"> <span class="icon">⬛</span> Dashboard </a>
      <a href="#" class="nav-link"> <span class="icon">📦</span> Inventory </a>
    </nav>
    <button class="logout-button" @click="handleLogout">
      <span class="icon">↩️</span> Logout
    </button>
  </div>
</template>

<script>
export default {
  name: "SidebarEmployee",
  methods: {
    handleLogout() {
      // Navigate back to the Login component
      this.$router.push({ name: "Login" });
    },
  },
};
</script>

<style scoped>
.sidebar-container {
  width: 250px;
  height: 100vh;
  background-color: #ffffff;
  display: flex;
  flex-direction: column;
  padding: 20px;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
  position: fixed;
  top: 0;
  left: 0;
}

h1 {
  font-family: 'Inter', sans-serif;
  font-size: 24px;
  color: #732222;
  margin-bottom: 20px;
  text-align: center;
}

.profile-section {
  text-align: center;
  margin-bottom: 30px;
  padding: 10px;
  border: 1px solidrgb(0, 0, 0);
  border-radius: 8px;
  width: 100%;
}

.profile-pic {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 10px;
}

.profile-name {
  font-size: 18px;
  font-weight: bold;
  color: #232d42;
  margin: 5px 0;
}

.profile-role {
  font-size: 14px;
  color: #8a92a6;
}
.home {
  color: #8a92a6;
  display: block;
  text-align: left;
  width: 100%;
  margin-bottom: 5px;
  background-color: wh
}

.nav-links {
 background-color:white;
  color: white;
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 25px;
  margin-bottom: auto;
}

.nav-link {
width: 90%;
  padding: 10px;
background-color: #E64444;
  border-radius: 5px;
  color: white;
}

.nav-link.active {
    background-color: #732222;
    color: white;
    }
.nav-link:hover {
  background-color:#992e2e;
  color:rgb(240, 240, 240);
}

.icon {
  margin-right: 10px;
}

.logout-button {
  width: 100%;
  padding: 10px;
  background-color: #E64444;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background-color 0.3s ease;
  margin-bottom: 3rem;
}

.logout-button:hover {
  background-color:#992e2e;
}

@media (max-width: 768px) {
  .sidebar-container {
    width: 200px;
    padding: 15px;
  }

  .profile-pic {
    width: 70px;
    height: 70px;
  }

  h1 {
    font-size: 20px;
  }

  .nav-link {
    font-size: 14px;
  }

  .logout-button {
    font-size: 14px;
  }
}
</style>
