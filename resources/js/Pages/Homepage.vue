<template>
  <!-- Navbar -->
  <header
    class=" p-4 flex justify-between items-center w-full fixed top-0 left-0 z-50 shadow-md"
  >
    <div class="text-white font-semibold py-2">Dar’s BBQ</div>
    <nav class="space-x-8 flex">
      <a href="#" class="text-white font-semibold py-2 hover:text-[#E64444]"
        >About Us</a
      >
      <a href="#" class="text-white font-semibold py-2">Contact Us</a>
      <a href="#" class="text-white font-semibold py-2">Location</a>
      <!-- <Link href = "/dashboard"> -->
      <button
        class="bg-[#E64444] text-white font-semibold py-2 px-4 rounded-md hover:bg-[#c33] focus:outline-none focus:ring-2 focus:ring-[#E64444]"
        @click="goToDashboard">
        Login Here
      </button>
    <!-- </Link> -->
    </nav>
  </header>

  <div
  class="fixed top-0 left-0 w-full h-screen bg-cover bg-center bg-no-repeat pt-20"
  :style="{ backgroundImage: `url(${backgroundImage})` }"
>


    <section
      class="flex flex-col items-center justify-center text-center text-white px-6 h-[calc(100vh-64px)]"
    >
      <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">
        Bringing the sizzle to every celebration!
      </h1>
      <p class="text-lg md:text-xl max-w-2xl drop-shadow-md">
        Dar's Barbeque is a Davao-based pop-up food business that began in
        August 2023, bringing its signature grilled barbeque to school events,
        food bazaars, and exclusive parties.
      </p>
    </section>
  </div>




  <!-- About us -->
  <section class="bg-pink-100 py-12">
  <h2 class="text-center text-3xl font-bold mb-8">About Us</h2>
  <div class="flex flex-col md:flex-row justify-center items-center gap-8 px-4">
    <!-- Team Member 1 -->
    <div class="text-center">
      <div class="w-32 h-32 bg-gray-300 rounded-full mx-auto mb-4"></div>
      <p class="font-semibold">Yuri M. Mantalaba</p>
      <p class="text-gray-600">COO</p>
    </div>
    <!-- Team Member 2 -->
    <div class="text-center">
      <div class="w-32 h-32 bg-gray-300 rounded-full mx-auto mb-4"></div>
      <p class="font-semibold">Arne Darylle P. Cambal</p>
      <p class="text-gray-600">CEO</p>
    </div>
    <!-- Team Member 3 -->
    <div class="text-center">
      <div class="w-32 h-32 bg-gray-300 rounded-full mx-auto mb-4"></div>
      <p class="font-semibold">Mark Anthony Molina</p>
      <p class="text-gray-600">CFO</p>
    </div>
  </div>
</section>
</template>

<script>
import backgroundImage from "@/assets/image2.png";
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'

function goToReports() {
  router.visit('/employees')
}

export default {
  name: "Homepage",
  data() {
    return {
      backgroundImage,
    };
  },
  methods: {
    navigateToLogin() {
      this.$router.push("/login");
    },
  },
};
</script>

<style scoped>
header {
  background-color: #992e2e;
}
</style>
