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
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
            />
        </div>

        <!-- Position -->
        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700"
                >Position</label
            >
            <input
                type="text"
                id="position"
                v-model="newEmployee.position"
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
            />
        </div>

        <!-- Address -->
        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700"
                >Address</label
            >
            <input
                type="text"
                id="address"
                v-model="newEmployee.address"
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
            />
        </div>

        <!-- Profile Picture -->
        <div class="mb-4">
            <label
                for="profilePicture"
                class="block text-sm font-medium text-gray-700"
                >Profile Picture</label
            >
            <input
                type="file"
                id="profilePicture"
                @change="onFileChange"
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
                placeholder="Upload a profile picture"
            />
            <p class="text-sm text-gray-500 mt-1">
                Optional: Upload a profile picture for the employee.
            </p>
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
export default {
    name: "AddEmployeeRecord",
    data() {
        return {
            newEmployee: {
                id: null,
                name: "",
                email: "",
                role: "",
                contact: "",
                profilePicture: null,
            },
        };
    },
    methods: {
        generateRandomId() {
            return Math.floor(1000 + Math.random() * 9000);
        },

        onFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                const validTypes = ["image/jpeg", "image/png", "image/gif"];
                const maxSize = 5 * 1024 * 1024;

                if (!validTypes.includes(file.type)) {
                    alert("Please upload a valid image (JPEG, PNG, or GIF).");
                    return;
                }

                if (file.size > maxSize) {
                    alert("File size exceeds 5MB limit.");
                    return;
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.newEmployee.profilePicture = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        addEmployee() {
            this.newEmployee.id = this.generateRandomId();
            this.$emit("add-employee", { ...this.newEmployee });

            this.newEmployee = {
                id: null,
                name: "",
                email: "",
                contact: "",
                position: "",
                address: "",
                profilePicture: null,
            };
        },
    },
};
</script>
