<template>
    <div v-if="employees && employees.length">
        <div class="p-4 bg-white shadow rounded-lg">
            <h2 class="text-xl font-bold text-gray-700 mb-4">
                Employee Details
            </h2>
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-2">Remarks</th>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Timed In</th>
                        <th class="px-4 py-2">Timed Out</th>
                        <th class="px-4 py-2">Overtime</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="employee in employees"
                        :key="employee.id"
                        class="border-b hover:bg-gray-50"
                    >
                        <td class="px-4 py-2">{{ employee.remarks }}</td>
                        <td class="px-4 py-2">{{ employee.date }}</td>
                        <td class="px-4 py-2">{{ employee.timein }}</td>
                        <td class="px-4 py-2">{{ employee.timeout }}</td>
                        <td class="px-4 py-2">{{ employee.overtime }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div v-else class="text-center text-gray-500 py-8">
        Employee record not found.
    </div>
</template>

<script>
export default {
    name: "EmployeeRecord",
    props: {
        employees: {
            type: Array,
            required: true,
        },
    },
};
</script>
