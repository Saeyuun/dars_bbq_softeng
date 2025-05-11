<template>
    <div
        v-if="show"
        class="fixed inset-0 bg-[#FFEDED] bg-opacity-50 flex items-center justify-center z-50"
    >
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full text-center">
            <div class="flex flex-col items-center mb-6">
                <img
                    :src="employee.avatar_url || 'https://via.placeholder.com/150'"
                    alt="Profile Picture"
                    class="w-20 h-20 rounded-full object-cover mb-4"
                />
                <h3 class="text-lg font-semibold text-gray-800">
                    {{ employee.employee_name }}
                </h3>
                <p class="text-sm text-gray-500">ID: {{ employee.employee_id }}</p>
            </div>

            <p class="text-gray-600 mb-6">
                Are you sure you want to delete this employee? This action cannot be undone.
            </p>

            <div class="flex justify-center space-x-4">
                <button
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400"
                    @click="$emit('close')"
                >
                    Cancel
                </button>
                <button
                    class="px-4 py-2 bg-[#E64444] text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400"
                    @click="deleteEmployee"
                    :disabled="form.processing"
                >
                    Delete Employee
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/vue3';

export default {
    name: "DeleteEmployee",
    props: {
        show: {
            type: Boolean,
            required: true,
        },
        employee: {
            type: Object,
            required: true,
        },
    },
    setup(props, { emit }) {
        const form = useForm({});

        const deleteEmployee = () => {
            form.delete(`/employees/${props.employee.employee_id}`, {
                onSuccess: () => {
                    emit('close');
                }
            });
        };

        return {
            form,
            deleteEmployee
        };
    }
};
</script>
