<template>
  <div class="w-64 h-full bg-white flex flex-col p-5 shadow-lg fixed top-0 left-0 z-40">
    <h1 class="text-2xl font-medium text-[#732222] text-center mb-5">Dar's BBQ</h1>

    <div class="text-center mb-8 p-4 rounded-lg w-full">
      <div class="relative w-36 h-36 mx-auto cursor-pointer group" @click="triggerFileInput">
        <img class="w-full h-full rounded-[30px] object-cover" 
             :src="userAvatar || 'https://i.pinimg.com/736x/a8/45/2b/a8452b369156bec21cf5a665ac5458a4.jpg'" 
             alt="User Avatar" />
        <div class="absolute inset-0 bg-black/50 rounded-[30px] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
          <span class="text-white w-6 h-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
          </span>
        </div>
        <input type="file" ref="fileInput" class="hidden" accept="image/*" @change="handleFileUpload" />
      </div>
      <p class="text-lg font-bold text-[#232d42] mt-2">Winter</p>
    </div>

    <nav class="flex flex-col gap-6 mb-auto">
      <Link href="/maindashboard" class="flex items-center gap-3 p-3 bg-[#e64444] rounded-md text-white hover:bg-[#992e2e] transition-colors">
        <span class="w-5 h-5">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 10h4V3H3v7zm0 11h4v-6H3v6zm7 0h4v-4h-4v4zm7 0h4V10h-4v11z" />
          </svg>
        </span>
        Dashboard
      </Link>

      <Link href="/inventory" class="flex items-center gap-3 p-3 bg-[#e64444] rounded-md text-white hover:bg-[#992e2e] transition-colors">
        <span class="w-5 h-5">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0H4" />
          </svg>
        </span>
        Inventory
      </Link>

      <Link href="/history" class="flex items-center gap-3 p-3 bg-[#e64444] rounded-md text-white hover:bg-[#992e2e] transition-colors">
        <span class="w-5 h-5">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </span>
        History
      </Link>

      <Link href="/employees" class="flex items-center gap-3 p-3 bg-[#e64444] rounded-md text-white hover:bg-[#992e2e] transition-colors">
        <span class="w-5 h-5">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 20h5v-2a4 4 0 00-5-4m-6 6v-2a4 4 0 015-4m-6 6H6v-2a4 4 0 015-4m-6 6a4 4 0 01-4-4v-2a4 4 0 014-4m6 6a4 4 0 004-4v-2a4 4 0 00-4-4m0 0a4 4 0 00-4 4v2a4 4 0 004 4z" />
          </svg>
        </span>
        Employees
      </Link>
    </nav>

    <button class="w-full p-3 bg-[#e64444] rounded-md text-white font-semibold text-lg flex items-center gap-3 justify-start hover:bg-[#992e2e] transition-colors mt-6"
            @click="logout">
      <span class="w-5 h-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
        </svg>
      </span>
      Logout
    </button>
  </div>
</template>

<script>
import { Link, router } from '@inertiajs/vue3';

export default {
  name: "Sidebar",
  data() {
    return {
      userAvatar: null,
    };
  },
  methods: {
    logout() {
      router.post('/logout');
    },
    triggerFileInput() {
      this.$refs.fileInput.click();
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.userAvatar = URL.createObjectURL(file);
      }
    }
  }
};
</script>
