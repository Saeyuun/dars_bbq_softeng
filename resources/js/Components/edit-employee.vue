<template>
    <form @submit.prevent="submitForm">
        <!-- Profile Picture -->
        <div class="flex justify-center mb-6">
            <img
                :src="employee.avatar_url || 'https://via.placeholder.com/150'"
                alt="Profile Picture"
                class="w-20 h-20 rounded-full object-cover"
            />
        </div>

        <!-- Employee Name and ID -->
        <div class="text-center mb-6">
            <h3 class="text-lg font-semibold text-gray-800">
                {{ employee.employee_name }}
            </h3>
            <p class="text-sm text-gray-500">ID: {{ employee.employee_id }}</p>
        </div>

        <!-- Name -->
        <div class="mb-4">
            <label for="employee_name" class="block text-sm font-medium text-gray-700">Name</label>
            <input
                type="text"
                id="employee_name"
                v-model="form.employee_name"
                required
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
            />
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
                type="email"
                id="email"
                v-model="form.email"
                required
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
            />
        </div>

        <!-- Contact Number -->
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Contact No.</label>
            <input
                type="text"
                id="phone"
                v-model="form.phone"
                required
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
            />
        </div>

        <!-- Position -->
        <div class="mb-4">
            <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
            <input
                type="text"
                id="position"
                v-model="form.position"
                required
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
            />
        </div>

        <!-- Address -->
        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
            <input
                type="text"
                id="address"
                v-model="form.address"
                required
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
            />
        </div>

        <!-- Profile Picture -->
        <div class="mb-4">
            <label for="profile_picture" class="block text-sm font-medium text-gray-700">Profile Picture (Optional)</label>
            <input
                type="file"
                id="profile_picture"
                @change="onFileChange"
                accept="image/*"
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
            />
        </div>

        <!-- Save Changes Button -->
        <button
            type="submit"
            class="w-full bg-[#E64444] text-white font-semibold py-2 rounded-md hover:bg-[#c33] focus:outline-none focus:ring-2 focus:ring-[#E64444]"
            :disabled="form.processing"
        >
            Save Changes
        </button>
    </form>

    <!-- Success Notification -->
    <div v-if="showNotification" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-[100]">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Employee updated successfully!
        </div>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

export default {
    name: "EditEmployeeRecord",
    emits: ['close'],
    props: {
        employee: {
            type: Object,
            required: true
        }
    },
    setup(props, { emit }) {
        const form = useForm({
            employee_name: props.employee.employee_name,
            email: props.employee.email,
            phone: props.employee.phone,
            position: props.employee.position,
            address: props.employee.address,
            profile_picture: null
        });

        const showNotification = ref(false);

        const showSuccessNotification = () => {
            showNotification.value = true;
            setTimeout(() => {
                showNotification.value = false;
            }, 3000);
        };

        const submitForm = () => {
            form.put(`/employees/${props.employee.employee_id}`, {
                onSuccess: () => {
                    showSuccessNotification();
                    setTimeout(() => {
                        emit('close');
                    }, 1000);
                }
            });
        };

        return { 
            form,
            showNotification,
            showSuccessNotification,
            submitForm
        };
    },
    methods: {
        onFileChange(event) {
            this.form.profile_picture = event.target.files[0];
        }
    }
};
</script>
