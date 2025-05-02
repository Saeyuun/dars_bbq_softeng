<template>
    <div
        v-if="show"
        class="fixed inset-0 bg-[#FFEDED] bg-opacity-50 flex items-center justify-center z-50"
    >
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full relative">
            <!-- Close Button -->
            <button
                class="absolute top-2 right-2 text-gray-500 hover:text-red-500 focus:outline-none"
                @click="closeModal"
            >
                ✕
            </button>

            <!-- Item Info -->
            <div class="flex flex-col items-center mb-6">
                <img
                    :src="
                        item.profilePicture || 'https://via.placeholder.com/150'
                    "
                    alt="Profile Picture"
                    class="w-20 h-20 rounded-full object-cover mb-4"
                />
                <h3 class="text-lg font-semibold text-gray-800">
                    {{ item.name }}
                </h3>
                <p class="text-sm text-gray-500">ID: {{ item.id }}</p>
            </div>

            <!-- Delete Button -->
            <button
                class="w-full bg-[#E64444] text-white font-semibold py-2 rounded-md hover:bg-[#c33] focus:outline-none focus:ring-2 focus:ring-[#E64444]"
                @click="confirmDelete"
            >
                Delete item
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "DeleteItem",
    props: {
        show: {
            type: Boolean,
            required: true,
        },
        item: {
            type: Object,
            required: true,
        },
    },
    methods: {
        closeModal() {
            this.$emit("close");
        },
        confirmDelete() {
            this.$emit("delete", this.item.id);
        },
    },
};
</script>
