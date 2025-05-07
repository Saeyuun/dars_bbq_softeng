<template>
    <Head title="Homepage" />
    <!-- Navbar -->
    <header
        class="p-4 flex justify-between items-center w-full fixed top-0 left-0 z-50 shadow-md"
    >
        <div class="text-white font-semibold py-2">Dar’s BBQ</div>
        <nav class="space-x-8 flex">
            <a
                href="#about-us"
                class="text-white font-semibold py-2 hover:text-[#E64444]"
            >
                About Us
            </a>
            <a
                href="#contact-us"
                class="text-white font-semibold py-2 hover:text-[#E64444]"
                >Contact Us</a
            >
            <a
                href="#"
                class="text-white font-semibold py-2 hover:text-[#E64444]"
                >Location</a
            >
            <Link
                href="/login"
                method="get"
                as="button"
                class="bg-[#E64444] inline-flex items-center text-white font-semibold py-2 px-4 rounded-md hover:bg-[#c33] focus:outline-none focus:ring-2 focus:ring-[#E64444]"
            >
                Login Here
            </Link>
        </nav>
    </header>

    <!-- Hero Section with Background Image -->
    <div
        class="relative w-full bg-cover bg-center bg-no-repeat pt-20"
        :style="{ backgroundImage: `url(${backgroundImage})` }"
    >
        <section
            class="flex flex-col items-center justify-center text-center text-white px-6 min-h-[calc(100vh-64px)]"
        >
            <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">
                Bringing the sizzle to every celebration!
            </h1>
            <p class="text-lg md:text-xl max-w-2xl drop-shadow-md">
                Dar's Barbeque is a Davao-based pop-up food business that began
                in August 2023, bringing its signature grilled barbeque to
                school events, food bazaars, and exclusive parties.
            </p>
        </section>
    </div>

    <AboutUsPage />

    <div class="mt-30">
        <ContactUsPage />
    </div>
</template>

<script>
import backgroundImage from "@/assets/image2.png";
import { Link } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import AboutUsPage from "./AboutUs.vue";
import ContactUsPage from "./ContactUs.vue";
export default {
    name: "Homepage",
    components: {
        Link,
        Head,
        AboutUsPage,
        ContactUsPage,
    },
    data() {
        return {
            backgroundImage,
        };
    },
};
</script>
<style>
html {
    scroll-behavior: smooth;
}
</style>

<style scoped>
header {
    background-color: #992e2e;
}
</style>
