<template>
    <div
        v-if="show"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
        <div
            class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center"
        >
            <h2 class="text-2xl font-bold text-[#E64444] mb-4">
                Employee Not Found
            </h2>
            <p class="text-gray-700 mb-6">
                No records found for this employee or the search bar is empty.
            </p>
            <button
                class="bg-[#E64444] text-white px-6 py-2 rounded font-semibold hover:bg-red-700 transition"
                @click="$emit('close')"
            >
                I Understand
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "SearchAlert",
    props: {
        show: {
            type: Boolean,
            default: false,
        },
    },
    emits: ["close"],
};
</script>
