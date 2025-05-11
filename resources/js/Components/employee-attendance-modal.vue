<template>
    <div class="fixed inset-0 bg-[#FFEDED] bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full relative">
            <button class="absolute top-2 right-2 text-gray-500 hover:text-[#E64444]" @click="$emit('close')">
                ✕
            </button>
            <h2 class="text-xl font-bold text-center text-[#E64444] mb-4">
                {{ employee.employee_name }}'s Attendance
            </h2>

            <div class="mb-4">
                <DateFilter @date-change="updateSelectedDate" />
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Time In
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Time Out
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Remarks
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <template v-if="filteredRecords.length > 0">
                            <tr v-for="record in filteredRecords" :key="record.login_id" class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ record.date }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ record.time_in }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ record.time_out || '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span :class="{
                                        'px-2 py-1 rounded-full text-xs font-semibold': true,
                                        'bg-green-100 text-green-800': record.status === 'Present',
                                        'bg-red-100 text-red-800': record.status === 'Absent',
                                        'bg-yellow-100 text-yellow-800': record.status === 'Late'
                                    }">
                                        {{ record.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ record.remark || '-' }}
                                </td>
                            </tr>
                        </template>
                        <tr v-else>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                No attendance records found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import DateFilter from "@/Components/date-filter.vue";

export default {
    name: "EmployeeAttendanceModal",
    components: {
        DateFilter,
    },

    props: {
        employee: {
            type: Object,
            required: true
        }
    },

    emits: ['close'],

    data() {
        return {
            selectedDate: "",
        };
    },

    computed: {
        filteredRecords() {
            console.log('Employee data in modal:', this.employee);
            console.log('Attendance records:', this.employee?.attendance);

            if (!this.selectedDate) {
                const records = (this.employee?.attendance || []).map(record => ({
                    ...record,
                    date: new Date(record.time_in).toLocaleDateString(),
                    time_in: new Date(record.time_in).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                    time_out: record.time_out ? new Date(record.time_out).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : '-',
                    status: record.status || this.getStatus(record)
                }));
                console.log('Formatted records:', records);
                return records;
            }

            const selected = new Date(this.selectedDate)
                .toISOString()
                .split("T")[0];

            const filteredRecords = (this.employee?.attendance || [])
                .filter(record => new Date(record.time_in).toISOString().split('T')[0] === selected)
                .map(record => ({
                    ...record,
                    date: new Date(record.time_in).toLocaleDateString(),
                    time_in: new Date(record.time_in).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                    time_out: record.time_out ? new Date(record.time_out).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : '-',
                    status: record.status || this.getStatus(record)
                }));
            console.log('Filtered records:', filteredRecords);
            return filteredRecords;
        }
    },

    methods: {
        updateSelectedDate(date) {
            this.selectedDate = date;
        },
        getStatus(record) {
            if (!record.time_out) {
                return 'Present';
            }
            const timeIn = new Date(record.time_in);
            const timeOut = new Date(record.time_out);
            const hoursWorked = (timeOut - timeIn) / (1000 * 60 * 60);
            
            if (hoursWorked < 8) {
                return 'Late';
            }
            return 'Present';
        }
    },
};
</script> 