<template>
    <form @submit.prevent="editEmployee">
        <!-- Profile Picture -->
        <div class="flex justify-center mb-6">
            <img
                :src="
                    employee.profilePicture || 'https://via.placeholder.com/150'
                "
                alt="Profile Picture"
                class="w-20 h-20 rounded-full object-cover"
            />
        </div>

        <!-- Employee Name and ID -->
        <div class="text-center mb-6">
            <h3 class="text-lg font-semibold text-gray-800">
                {{ employee.name }}
            </h3>
            <p class="text-sm text-gray-500">ID: {{ employee.id }}</p>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700"
                >Email</label
            >
            <input
                type="email"
                id="email"
                v-model="newEmployee.email"
                required
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
            />
        </div>

        <!-- Contact Number -->
        <div class="mb-4">
            <label for="contact" class="block text-sm font-medium text-gray-700"
                >Contact No.</label
            >
            <input
                type="text"
                id="contact"
                v-model="newEmployee.contact"
                required
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
            />
        </div>

        <!-- Position -->
        <div class="mb-4">
            <label
                for="position"
                class="block text-sm font-medium text-gray-700"
                >Position</label
            >
            <input
                type="text"
                id="position"
                v-model="newEmployee.position"
                required
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
            />
        </div>

        <!-- Address -->
        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700"
                >Address</label
            >
            <input
                type="text"
                id="address"
                v-model="newEmployee.address"
                required
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
            />
        </div>

        <!-- Save Changes Button -->
        <button
            type="submit"
            class="w-full bg-[#E64444] text-white font-semibold py-2 rounded-md hover:bg-[#c33] focus:outline-none focus:ring-2 focus:ring-[#E64444]"
        >
            Save Changes
        </button>
    </form>
</template>

<script>
export default {
    name: "EditEmployeeRecord",
    props: {
        employee: Object,
    },
    data() {
        return {
            newEmployee: {
                email: "",
                position: "",
                contact: "",
                address: "",
            },
        };
    },
    watch: {
        employee: {
            immediate: true,
            handler(newVal) {
                if (newVal) {
                    this.newEmployee = { ...newVal };
                }
            },
        },
    },
    methods: {
        editEmployee() {
            this.$emit("edit-employee", { ...this.newEmployee });
        },
    },
};
</script>
