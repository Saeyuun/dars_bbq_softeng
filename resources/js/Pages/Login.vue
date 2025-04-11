<template>
  <div class="login-container">
    <div class="form-section">
      <div class="logo-section">
        <img src="../assets/image-1.png" class="logo" alt="logo" />
      </div>

      <h1>Dar's BBQ</h1>

      <h2>Log In</h2>
      <form @submit.prevent="handleLogin">
        <label for="username">Username</label>
        <input type="text" id="username" v-model="username" />
        <label for="password">Password</label>
        <input type="password" id="password" v-model="password" />
        <button type="submit" class="login-button">Sign In</button>
      </form>
    </div>

    <div class="image-sidebar">
      <img src="../assets/image-2.png" class="image-2" alt="BBQ Image" />
    </div>
  </div>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      username: "",
      password: "",
    };
  },
  methods: {
    handleLogin() {
      
      this.$router.push({ name: "Inventory" });
    },
  },
};
</script>

<style scoped>
.login-container {
  display: flex;
  height: 100vh;
  width: 100%;
}

.form-section {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 130px;
  background-color: #ffffff;
}

.logo-section {
  position: absolute;
  top: 20px;
  left: 20px;
}

.logo {
  width: 80px;
  height: auto;
  object-fit: contain;
}

h1 {
  font-family: Inter, sans-serif;
  font-size: 24px;
  color: #232d42;
  text-align: left;
  margin-bottom: 10px;
}

h2 {
  font-size: 20px;
  color: #000000;
  margin-bottom: 20px;
}

form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: white;
  color: #000;
}

.login-button {
  padding: 12px;
  background-color: #732222;
  color: white;
  border-radius: 5px;
  cursor: pointer;
  font-size: 13px;
  width: 45%;
  display: block;
  margin: 0 auto;
}

label {
  color: #8a92a6;
  display: block;
  text-align: left;
  width: 100%;
  margin-bottom: 5px;
}

.login-button:hover {
  background-color: #5a1a1a;
}

.image-sidebar {
  flex: 1;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 auto;
}

.image-2 {
  width: 100%;
  height: 100vh;
  object-fit: cover;
}
</style>