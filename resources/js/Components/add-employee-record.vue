<template>
    <form @submit.prevent="addEmployee">
        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700"
                >Name</label
            >
            <input
                type="text"
                id="name"
                v-model="newEmployee.name"
                required
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
            />
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
            <label for="position" class="block text-sm font-medium text-gray-700"
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

        <!-- Profile Picture -->
        <div class="mb-4">
            <label
                for="profile_picture"
                class="block text-sm font-medium text-gray-700"
                >Profile Picture (Optional)</label
            >
            <input
                type="file"
                id="profile_picture"
                @change="onFileChange"
                accept="image/*"
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
            />
        </div>

        <!-- Add Employee Button -->
        <button
            type="submit"
            class="w-full bg-[#E64444] text-white font-semibold py-2 rounded-md hover:bg-[#c33] focus:outline-none focus:ring-2 focus:ring-[#E64444]"
        >
            Add Employee
        </button>
    </form>
</template>

<script>
import { router } from "@inertiajs/vue3";

export default {
    name: "AddEmployeeRecord",
    data() {
        return {
            newEmployee: {
                name: "",
                email: "",
                contact: "",
                position: "",
                address: "",
                profile_picture: null,
            },
        };
    },
    methods: {
        onFileChange(event) {
            this.newEmployee.profile_picture = event.target.files[0];
        },

        addEmployee() {
            const formData = new FormData();
            formData.append("employee_name", this.newEmployee.name);
            formData.append("email", this.newEmployee.email);
            formData.append("phone", this.newEmployee.contact);
            formData.append("position", this.newEmployee.position);
            formData.append("address", this.newEmployee.address);

            if (this.newEmployee.profile_picture) {
                formData.append("profile_picture", this.newEmployee.profile_picture);
            }

            router.post("/employees", formData, {
                onSuccess: () => {
                    this.$emit('close');
                    this.resetForm();
                },
            });
        },

        resetForm() {
            this.newEmployee = {
                name: "",
                email: "",
                contact: "",
                position: "",
                address: "",
                profile_picture: null,
            };
        },
    },
};
</script>
