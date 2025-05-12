<template>
    <Head title="Attendance" />
    <div class="flex flex-col sm:flex-row min-h-screen bg-gray-50">
        <div class="hidden sm:block">
            <Sidebar />
        </div>
        <div class="flex-1 p-4 sm:ml-[250px]">
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4"
            >
                <h1 class="text-2xl font-bold text-[#E64444] mb-2 sm:mb-0">
                    {{
                        showEmployeeAttendance
                            ? `${employee.employee_name}'s Attendance`
                            : "Attendance"
                    }}
                </h1>
            </div>

            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <!-- Check In Card -->
                <div
                    class="bg-white rounded-xl shadow-lg p-4 flex flex-col min-w-[180px] max-w-xs w-full items-center justify-center"
                >
                    <div
                        class="w-full flex flex-col items-center justify-center flex-1 text-center"
                    >
                        <div class="text-base font-semibold text-gray-700 mb-1">
                            Check In
                        </div>
                        <div class="text-xs text-gray-400 mb-1">
                            {{ todayDate }}
                        </div>
                        <div class="text-xl font-bold text-gray-800 mb-4">
                            {{ currentTime }}
                        </div>
                    </div>
                    <button
                        @click="checkIn"
                        class="bg-green-500 hover:bg-green-600 text-white px-8 py-2 rounded-lg font-semibold text-base shadow-md w-full transition-all duration-200 mt-auto"
                    >
                        Check In
                    </button>
                </div>

                <!-- Remarks & Check Out Card -->
                <div
                    class="flex-1 bg-white rounded-xl shadow-lg p-4 flex flex-col min-w-[220px] max-w-md"
                >
                    <div class="w-full flex flex-col">
                        <label
                            class="text-sm font-semibold text-gray-700 mb-1"
                            for="remarks"
                            >Add remarks for today's attendance</label
                        >
                        <textarea
                            id="remarks"
                            v-model="checkOutRemark"
                            placeholder="Add remarks for today's attendance..."
                            class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#E64444] focus:border-transparent transition-all duration-200 resize-none mb-1"
                            rows="3"
                            maxlength="500"
                        ></textarea>
                        <div class="text-right text-xs text-gray-400 mb-2">
                            {{ checkOutRemark.length }}/500
                        </div>
                        <button
                            @click="checkOut"
                            class="bg-[#E64444] hover:bg-red-600 text-white px-8 py-2 rounded-lg font-semibold text-base shadow-md w-full transition-all duration-200"
                        >
                            Check Out
                        </button>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <DateFilter @date-change="updateSelectedDate" />
            </div>
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                v-if="!showEmployeeAttendance"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Employee
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Date
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Time In
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Time Out
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Status
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Remarks
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <template v-if="filteredRecords.length > 0">
                            <tr
                                v-for="record in filteredRecords"
                                :key="record.id"
                                class="hover:bg-gray-50 transition"
                            >
                                <td
                                    v-if="!showEmployeeAttendance"
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                >
                                    {{ record.employee_name }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                >
                                    {{ record.date }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                >
                                    {{ record.time_in }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                >
                                    {{ record.time_out || "-" }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span
                                        :class="{
                                            'px-2 py-1 rounded-full text-xs font-bold':
                                                record.status === 'present' ||
                                                record.status === 'Present',
                                            'px-2 py-1 rounded-full text-xs font-semibold':
                                                record.status !== 'present' &&
                                                record.status !== 'Present',
                                            'bg-green-100 text-green-800':
                                                record.status === 'present' ||
                                                record.status === 'Present',
                                            'bg-red-100 text-red-800':
                                                record.status === 'Absent',
                                            'bg-yellow-100 text-yellow-800':
                                                record.status === 'Late',
                                        }"
                                    >
                                        {{ record.status }}
                                    </span>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-[#E64444] font-medium"
                                >
                                    <button
                                        @click="showRemarkDetails(record)"
                                        class="hover:underline"
                                    >
                                        {{
                                            record.remark
                                                ? "View Remarks"
                                                : "No Remarks"
                                        }}
                                    </button>
                                </td>
                            </tr>
                        </template>
                        <tr v-else>
                            <td
                                :colspan="showEmployeeAttendance ? 5 : 6"
                                class="px-6 py-4 text-center text-sm text-gray-500"
                            >
                                No attendance records found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Remark Details Modal -->
            <div
                v-if="selectedRecord"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            >
                <div
                    class="bg-white p-6 rounded-lg shadow-lg max-w-2xl w-full relative"
                >
                    <button
                        class="absolute top-2 right-2 text-gray-500 hover:text-[#E64444]"
                        @click="selectedRecord = null"
                    >
                        ✕
                    </button>
                    <h3 class="text-xl font-bold text-[#E64444] mb-4">
                        Attendance Details
                    </h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Date</p>
                                <p class="font-medium">
                                    {{ selectedRecord.date }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <p class="font-medium">
                                    {{ selectedRecord.status }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Time In</p>
                                <p class="font-medium">
                                    {{ selectedRecord.time_in }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Time Out</p>
                                <p class="font-medium">
                                    {{ selectedRecord.time_out || "-" }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Remarks</p>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-700">
                                    {{
                                        selectedRecord.remark ||
                                        "No remarks provided"
                                    }}
                                </p>
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
            default: null,
        },
        showEmployeeAttendance: {
            type: Boolean,
            default: false,
        },
        employees: {
            type: Array,
            default: () => [],
        },
    },

    computed: {
        filteredRecords() {
            if (!this.selectedDate) {
                if (this.showEmployeeAttendance) {
                    const records = (this.employee?.attendance || []).map(
                        (record) => ({
                            ...record,
                            date: new Date(record.time_in).toLocaleDateString(),
                            time_in: new Date(
                                record.time_in
                            ).toLocaleTimeString([], {
                                hour: "2-digit",
                                minute: "2-digit",
                            }),
                            time_out: record.time_out
                                ? new Date(record.time_out).toLocaleTimeString(
                                      [],
                                      { hour: "2-digit", minute: "2-digit" }
                                  )
                                : "-",
                            status: record.status || this.getStatus(record),
                        })
                    );
                    console.log("Employee attendance records:", records);
                    return records;
                }
                // For admin view, combine all employee attendance records
                return this.employees.flatMap((emp) =>
                    (emp.attendance || []).map((record) => ({
                        ...record,
                        employee_name: emp.employee_name,
                        date: new Date(record.time_in).toLocaleDateString(),
                        time_in: new Date(record.time_in).toLocaleTimeString(
                            [],
                            { hour: "2-digit", minute: "2-digit" }
                        ),
                        time_out: record.time_out
                            ? new Date(record.time_out).toLocaleTimeString([], {
                                  hour: "2-digit",
                                  minute: "2-digit",
                              })
                            : "-",
                        status: record.status || this.getStatus(record),
                    }))
                );
            }

            const selected = new Date(this.selectedDate)
                .toISOString()
                .split("T")[0];

            if (this.showEmployeeAttendance) {
                return (this.employee?.attendance || [])
                    .filter(
                        (record) =>
                            new Date(record.time_in)
                                .toISOString()
                                .split("T")[0] === selected
                    )
                    .map((record) => ({
                        ...record,
                        date: new Date(record.time_in).toLocaleDateString(),
                        time_in: new Date(record.time_in).toLocaleTimeString(
                            [],
                            { hour: "2-digit", minute: "2-digit" }
                        ),
                        time_out: record.time_out
                            ? new Date(record.time_out).toLocaleTimeString([], {
                                  hour: "2-digit",
                                  minute: "2-digit",
                              })
                            : "-",
                        status: record.status || this.getStatus(record),
                    }));
            }

            // For admin view, filter combined records
            return this.employees.flatMap((emp) =>
                (emp.attendance || [])
                    .filter(
                        (record) =>
                            new Date(record.time_in)
                                .toISOString()
                                .split("T")[0] === selected
                    )
                    .map((record) => ({
                        ...record,
                        employee_name: emp.employee_name,
                        date: new Date(record.time_in).toLocaleDateString(),
                        time_in: new Date(record.time_in).toLocaleTimeString(
                            [],
                            { hour: "2-digit", minute: "2-digit" }
                        ),
                        time_out: record.time_out
                            ? new Date(record.time_out).toLocaleTimeString([], {
                                  hour: "2-digit",
                                  minute: "2-digit",
                              })
                            : "-",
                        status: record.status || this.getStatus(record),
                    }))
            );
        },
    },

    data() {
        return {
            selectedDate: "",
            attendanceRecords: [],
            checkOutRemark: "",
            selectedRecord: null,
            currentTime: this.getCurrentTime(),
            todayDate: this.getTodayDate(),
        };
    },

    methods: {
        updateSelectedDate(date) {
            this.selectedDate = date;
        },
        getStatus(record) {
            if (!record.time_out) {
                return "Present";
            }
            const timeIn = new Date(record.time_in);
            const timeOut = new Date(record.time_out);
            const hoursWorked = (timeOut - timeIn) / (1000 * 60 * 60);

            if (hoursWorked < 8) {
                return "Late";
            }
            return "Present";
        },
        checkIn() {
            router.post(
                route("attendance.check-in"),
                {},
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        // Refresh the page to show updated attendance
                        router.reload({ only: ["employee"] });
                    },
                }
            );
        },
        checkOut() {
            if (this.checkOutRemark.length > 500) {
                alert("Remarks cannot exceed 500 characters");
                return;
            }
            router.post(
                route("attendance.check-out"),
                {
                    remarks: this.checkOutRemark,
                },
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.checkOutRemark = "";
                        router.reload({ only: ["employee"] });
                    },
                }
            );
        },
        showRemarkDetails(record) {
            this.selectedRecord = record;
        },
        getCurrentTime() {
            const now = new Date();
            return now.toLocaleTimeString([], {
                hour: "2-digit",
                minute: "2-digit",
            });
        },
        getTodayDate() {
            const now = new Date();
            return now.toLocaleDateString();
        },
    },

    mounted() {
        console.log("Employee data:", this.employee);
        console.log("Attendance records:", this.employee?.attendance);
        setInterval(() => {
            this.currentTime = this.getCurrentTime();
            this.todayDate = this.getTodayDate();
        }, 60000);
    },
};
</script>

<style scoped>
textarea {
    resize: none;
}
</style>
