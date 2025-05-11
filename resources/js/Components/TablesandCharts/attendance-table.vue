<template>
    <div v-if="show" class="overflow-x-auto bg-white shadow rounded mb-4">
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-lg font-bold text-gray-800">
                <template v-if="employees.length === 1">
                    Details of
                    <span class="text-[#E64444] font-bold">{{
                        employees[0].name
                    }}</span>
                </template>
                <template v-else> Employee Details </template>
            </h2>
            <button
                class="rounded bg-gray-200 px-3 py-1 text-sm text-gray-700 hover:bg-gray-300"
                @click="$emit('close')"
            >
                Back
            </button>
        </div>
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                <tr>
                    <th class="px-6 py-3">Remarks</th>
                    <th class="px-6 py-3">Date</th>
                    <th class="px-6 py-3">Timed In</th>
                    <th class="px-6 py-3">Timed Out</th>
                    <th class="px-6 py-3">Overtime</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="employees.length === 0">
                    <td colspan="5" class="text-center py-6 text-gray-500">
                        No employees found matching your search.
                    </td>
                </tr>
                <template v-else>
                    <tr v-for="employee in employees" :key="employee.id">
                        <td class="px-6 py-4">-</td>
                        <td class="px-6 py-4">-</td>
                        <td class="px-6 py-4">-</td>
                        <td class="px-6 py-4">-</td>
                        <td class="px-6 py-4">-</td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "AttendanceTable",
    props: {
        show: {
            type: Boolean,
            default: false,
        },
        employees: {
            type: Array,
            default: () => [],
        },
    },
    emits: ["close"],
};
</script>
