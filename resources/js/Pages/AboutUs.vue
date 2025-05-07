<template>
    <section id="about-us" class="bg-pink-100 py-12">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">About Us</h2>
        </div>
        <div class="flex justify-center space-x-8 px-4">
            <!-- Team Member 1 -->
            <div class="text-center">
                <div class="w-32 h-32 bg-gray-300 rounded-full mx-auto"></div>
                <h3 class="mt-4 text-lg font-semibold text-gray-800">
                    Yuri M. Mantalaba
                </h3>
                <p class="text-gray-600">COO</p>
            </div>
            <!-- Team Member 2 -->
            <div class="text-center">
                <div class="w-32 h-32 bg-gray-300 rounded-full mx-auto"></div>
                <h3 class="mt-4 text-lg font-semibold text-gray-800">
                    Arne Darylle P. Cambal
                </h3>
                <p class="text-gray-600">CEO</p>
            </div>
            <!-- Team Member 3 -->
            <div class="text-center">
                <div class="w-32 h-32 bg-gray-300 rounded-full mx-auto"></div>
                <h3 class="mt-4 text-lg font-semibold text-gray-800">
                    Mark Anthony Molina
                </h3>
                <p class="text-gray-600">CFO</p>
            </div>
        </div>
    </section>

    <!-- Mission and Vision Section -->
    <section class="bg-[#992e2e] text-white py-12">
        <div class="max-w-6xl mx-auto px-6 py-10 bg-[#E64444]">
            <div class="mb-8 bg-">
                <h2 class="text-2xl font-bold mb-4">Mission</h2>
                <p>
                    Dar’s BBQ provides mobile, affordable, and efficient food
                    services in high-traffic city locations, including food
                    bazaars, school events, campus stalls, and exclusive private
                    parties. Additionally, we aim to expand retail of marinated
                    meats, reaching both large and small stores.
                </p>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-4">Vision</h2>
                <p>
                    Dar’s BBQ aims to support responsible consumption and
                    production of food and beverages while maintaining
                    profitability. Through a refill-based marketing strategy,
                    they aim to control food waste and reduce packaging waste,
                    helping individuals enjoy food more efficiently.
                </p>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "AboutUsPage",
};
</script>

<style scoped>
#about-us {
    padding-top: 8rem;
}
</style>
