<template>
    <Head title="Attendance" />
    <div class="flex flex-col sm:flex-row min-h-screen">
        <div class="hidden sm:block">
            <Sidebar />
        </div>
        <div class="flex-1 p-4 sm:ml-[250px]">
            <div class="mb-4">
                <h1 class="text-2xl font-bold text-[#E64444]">
                    {{ showEmployeeAttendance ? `${employee.employee_name}'s Attendance` : 'Attendance' }}
                </h1>
            </div>

            <div v-if="showEmployeeAttendance" class="mb-8 bg-white p-6 rounded-lg shadow-lg">
                <div class="flex flex-col md:flex-row gap-6 items-center justify-between">
                    <form @submit.prevent="checkIn" class="w-full md:w-auto">
                        <button type="submit" 
                            class="w-full bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-lg font-semibold text-lg transition-all duration-200 transform hover:scale-105 shadow-md">
                            <i class="fas fa-sign-in-alt mr-2"></i>Check In
                        </button>
                    </form>
                    <form @submit.prevent="checkOut" class="w-full md:w-auto flex flex-col gap-4">
                        <div class="relative">
                            <textarea
                                v-model="checkOutRemark"
                                placeholder="Add remarks for today's attendance..."
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#E64444] focus:border-transparent transition-all duration-200"
                                rows="3"
                            ></textarea>
                            <div class="absolute bottom-2 right-2 text-sm text-gray-500">
                                {{ checkOutRemark.length }}/500
                            </div>
                        </div>
                        <button type="submit" 
                            class="w-full bg-[#E64444] hover:bg-red-600 text-white px-8 py-3 rounded-lg font-semibold text-lg transition-all duration-200 transform hover:scale-105 shadow-md">
                            <i class="fas fa-sign-out-alt mr-2"></i>Check Out
                        </button>
                    </form>
                </div>
            </div>
            <div class="mb-4">
                <DateFilter @date-change="updateSelectedDate" />
            </div>
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th v-if="!showEmployeeAttendance" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Employee
                            </th>
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
                            <tr v-for="record in filteredRecords" :key="record.id" class="hover:bg-gray-50">
                                <td v-if="!showEmployeeAttendance" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ record.employee_name }}
                                </td>
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
                                    <button 
                                        @click="showRemarkDetails(record)"
                                        class="text-[#E64444] hover:text-red-600 font-medium"
                                    >
                                        {{ record.remark ? 'View Remarks' : 'No Remarks' }}
                                    </button>
                                </td>
                            </tr>
                        </template>
                        <tr v-else>
                            <td :colspan="showEmployeeAttendance ? 5 : 6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No attendance records found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Remark Details Modal -->
            <div v-if="selectedRecord" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl w-full relative">
                    <button class="absolute top-2 right-2 text-gray-500 hover:text-[#E64444]" @click="selectedRecord = null">
                        ✕
                    </button>
                    <h3 class="text-xl font-bold text-[#E64444] mb-4">Attendance Details</h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Date</p>
                                <p class="font-medium">{{ selectedRecord.date }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <p class="font-medium">{{ selectedRecord.status }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Time In</p>
                                <p class="font-medium">{{ selectedRecord.time_in }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Time Out</p>
                                <p class="font-medium">{{ selectedRecord.time_out || '-' }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Remarks</p>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-700">{{ selectedRecord.remark || 'No remarks provided' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DateFilter from "@/Components/date-filter.vue";
import Sidebar from "@/Components/side-bar.vue";
import { Head, router } from "@inertiajs/vue3";

export default {
    name: "Attendance",
    components: {
        Sidebar,
        DateFilter,
        Head,
    },

    props: {
        employee: {
            type: Object,
            default: null
        },
        showEmployeeAttendance: {
            type: Boolean,
            default: false
        },
        employees: {
            type: Array,
            default: () => []
        }
    },

    computed: {
        filteredRecords() {
            if (!this.selectedDate) {
                if (this.showEmployeeAttendance) {
                    const records = (this.employee?.attendance || []).map(record => ({
                        ...record,
                        date: new Date(record.time_in).toLocaleDateString(),
                        time_in: new Date(record.time_in).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                        time_out: record.time_out ? new Date(record.time_out).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : '-',
                        status: record.status || this.getStatus(record)
                    }));
                    console.log('Employee attendance records:', records);
                    return records;
                }
                // For admin view, combine all employee attendance records
                return this.employees.flatMap(emp => 
                    (emp.attendance || []).map(record => ({
                        ...record,
                        employee_name: emp.employee_name,
                        date: new Date(record.time_in).toLocaleDateString(),
                        time_in: new Date(record.time_in).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                        time_out: record.time_out ? new Date(record.time_out).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : '-',
                        status: record.status || this.getStatus(record)
                    }))
                );
            }

            const selected = new Date(this.selectedDate)
                .toISOString()
                .split("T")[0];

            if (this.showEmployeeAttendance) {
                return (this.employee?.attendance || [])
                    .filter(record => new Date(record.time_in).toISOString().split('T')[0] === selected)
                    .map(record => ({
                        ...record,
                        date: new Date(record.time_in).toLocaleDateString(),
                        time_in: new Date(record.time_in).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                        time_out: record.time_out ? new Date(record.time_out).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : '-',
                        status: record.status || this.getStatus(record)
                    }));
            }

            // For admin view, filter combined records
            return this.employees.flatMap(emp => 
                (emp.attendance || [])
                    .filter(record => new Date(record.time_in).toISOString().split('T')[0] === selected)
                    .map(record => ({
                        ...record,
                        employee_name: emp.employee_name,
                        date: new Date(record.time_in).toLocaleDateString(),
                        time_in: new Date(record.time_in).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                        time_out: record.time_out ? new Date(record.time_out).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : '-',
                        status: record.status || this.getStatus(record)
                    }))
            );
        }
    },

    data() {
        return {
            selectedDate: "",
            attendanceRecords: [],
            checkOutRemark: "",
            selectedRecord: null,
        };
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
        },
        checkIn() {
            router.post(route('attendance.check-in'), {}, {
                preserveScroll: true,
                onSuccess: () => {
                    // Refresh the page to show updated attendance
                    router.reload({ only: ['employee'] });
                }
            });
        },
        checkOut() {
            if (this.checkOutRemark.length > 500) {
                alert('Remarks cannot exceed 500 characters');
                return;
            }
            router.post(route('attendance.check-out'), {
                remarks: this.checkOutRemark
            }, {
                preserveScroll: true,
                onSuccess: () => {
                    this.checkOutRemark = "";
                    router.reload({ only: ['employee'] });
                }
            });
        },
        showRemarkDetails(record) {
            this.selectedRecord = record;
        },
    },

    mounted() {
        console.log('Employee data:', this.employee);
        console.log('Attendance records:', this.employee?.attendance);
    },
};
</script>

<style scoped>
textarea {
    resize: none;
}
</style>
