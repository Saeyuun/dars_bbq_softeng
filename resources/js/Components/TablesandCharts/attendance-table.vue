<template>
    <div v-if="show" class="overflow-x-auto bg-white shadow rounded mb-4">
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-lg font-bold text-gray-800">
                <template v-if="employees.length === 1">
                    Attendance Records for
                    <span class="text-[#E64444] font-bold">{{
                        employees[0].employee_name
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
                    <th class="px-6 py-3">Date</th>
                    <th class="px-6 py-3">Time In</th>
                    <th class="px-6 py-3">Time Out</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Remarks</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="employees.length === 0 || !employees[0].attendance || employees[0].attendance.length === 0">
                    <td colspan="5" class="text-center py-6 text-gray-500">
                        No attendance records found.
                    </td>
                </tr>
                <template v-else>
                    <tr v-for="record in employees[0].attendance" :key="record.login_id" class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ new Date(record.time_in).toLocaleDateString() }}</td>
                        <td class="px-6 py-4">{{ new Date(record.time_in).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) }}</td>
                        <td class="px-6 py-4">{{ record.time_out ? new Date(record.time_out).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : '-' }}</td>
                        <td class="px-6 py-4">
                            <span :class="{
                                'px-2 py-1 rounded-full text-xs font-semibold': true,
                                'bg-green-100 text-green-800': record.status === 'Present',
                                'bg-red-100 text-red-800': record.status === 'Absent',
                                'bg-yellow-100 text-yellow-800': record.status === 'Late'
                            }">
                                {{ record.status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ record.remark || '-' }}</td>
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
