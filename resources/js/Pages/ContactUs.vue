<template>
    <section
        id="contact-us"
        class="min-h-screen flex flex-col justify-between py-16 bg-[#992e2e]"
    >
        <div class="max-w-5xl mx-auto w-full">
            <h1
                class="text-2xl md:text-3xl font-bold text-center text-white mb-8 drop-shadow-lg mt-24"
            >
                Want to inquire us?
            </h1>
        </div>
        <div
            class="max-w-5xl mx-auto w-full bg-white/90 rounded-xl shadow-lg p-8 flex flex-col md:flex-row gap-8 items-stretch mt-16"
        >
            <div class="flex-1 flex flex-col justify-center">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">
                    Contact us
                </h2>
                <form class="flex flex-col gap-4">
                    <input
                        type="text"
                        placeholder="Full name"
                        class="rounded-lg px-4 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#e64444]"
                    />
                    <input
                        type="email"
                        placeholder="E-mail"
                        class="rounded-lg px-4 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#e64444]"
                    />
                    <textarea
                        placeholder="Message"
                        rows="4"
                        class="rounded-lg px-4 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#e64444]"
                    ></textarea>
                    <button
                        type="button"
                        class="mt-2 py-2 rounded-lg text-white font-semibold shadow-md bg-gradient-to-r from-[#e64444] to-[#ff9966] hover:from-[#c33] hover:to-[#ffb380] transition"
                    >
                        Send
                    </button>
                </form>
            </div>

            <div class="flex-1 flex flex-col justify-center items-center gap-4">
                <div
                    class="w-full h-48 md:h-56 rounded-lg overflow-hidden shadow-md mb-4"
                >
                    <iframe
                        src="https://www.google.com/maps?q=Davao+City,+Philippines&output=embed"
                        width="100%"
                        height="100%"
                        style="border: 0"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                </div>
                <div
                    class="w-full flex flex-col md:flex-row justify-between text-gray-700 text-sm px-2"
                >
                    <div>
                        <div class="font-semibold">Where to find us</div>
                        <div>Davao Del Sur,<br />Davao City, Philippines</div>
                    </div>
                    <div class="mt-2 md:mt-0">
                        <div>Ardapca@gmail.com</div>
                        <div>0947 384 8033</div>
                        <a
                            href="https://www.facebook.com/profile.php?id=61554315867143"
                            target="_blank"
                            rel="noopener"
                            class="flex items-center gap-1 text-blue-600 hover:underline mt-1"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                                class="w-4 h-4"
                            >
                                <path
                                    d="M22.675 0h-21.35C.595 0 0 .592 0 1.326v21.348C0 23.408.595 24 1.325 24h11.495v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.797.143v3.24l-1.918.001c-1.504 0-1.797.715-1.797 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116C23.406 24 24 23.408 24 22.674V1.326C24 .592 23.406 0 22.675 0"
                                />
                            </svg>
                            Facebook Page
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <footer class="text-center py-4 text-gray-200 text-xs mt-12">
            <p>Copyright @ 2025</p>
        </footer>
    </section>
</template>

<script>
export default {
    name: "ContactUsPage",
};
</script>

<style scoped></style>
