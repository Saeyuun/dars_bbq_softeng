<template>
    <div class="login-container flex h-screen w-full bg-gray-100">
     
      <div class="hidden md:flex w-1/2 bg-[#732222] items-center justify-center">
        <img src="../assets/image-2.png" class="w-full h-full object-cover" alt="BBQ Image" />
      </div>
  
      
      <div class="flex flex-col justify-center items-center w-full md:w-1/2 px-8 py-6 bg-white relative">
        
        <div class="absolute top-4 left-4 flex items-center space-x-2">
          <img src="../assets/image-1.png" class="w-12 h-auto object-contain" alt="Logo Icon" />
        </div>
  
        
        <h1 class="text-3xl font-bold text-[#232d42] mb-2">Dar's BBQ</h1>
        <h2 class="text-lg text-gray-600 mb-6">Log In</h2>
  
        
        <form @submit.prevent="handleLogin" class="flex flex-col gap-4 w-full max-w-sm">
          
          <div>
            <label for="email" class="block text-gray-600 mb-1">Username</label>
            <input
              type="email"
              id="email"
              v-model="username"
              placeholder="Enter your username"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#732222]"
            />
          </div>
  
          
          <div>
            <label for="password" class="block text-gray-600 mb-1">Password</label>
            <input
              type="password"
              id="password"
              v-model="password"
              placeholder="Enter your password"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#732222]"
            />
          </div>
  
       
  
        
          <button
            type="submit"
            class="w-full py-3 bg-[#732222] text-white rounded-lg hover:bg-[#5a1a1a] transition"
          >
            Sign In
          </button>
        </form>
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
        this.$router.push({ name: "Employees" });
      },
    },
  };
  </script>
  
  <style scoped>
  
  
  
  </style>