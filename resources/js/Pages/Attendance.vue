<template>
    <Head title="Attendance" />
    <div class="flex flex-col sm:flex-row min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <div class="w-64">
            <Sidebar />
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6 items-start">
                <div class="bg-white p-6 rounded-lg shadow-md max-w-sm w-full">
                    <h2 class="text-lg font-bold text-[#E64444] mb-4">
                        {{
                            !isTimedIn
                                ? "Check In"
                                : !isTimedOut
                                ? "Check Out"
                                : "Attendance Complete"
                        }}
                    </h2>
                    <p class="text-sm text-gray-500">{{ currentDate }}</p>
                    <p class="text-2xl font-semibold text-gray-800 mt-2">
                        {{ currentTime }}
                    </p>

                    <template v-if="!isTimedIn">
                        <button
                            class="mt-10 w-full bg-[#5BD069] text-white text-base font-normal py-2 rounded hover:bg-green-700"
                            @click="confirmCheckIn"
                        >
                            Check In
                        </button>
                    </template>

                    <!-- Check Out Section -->
                    <template v-else-if="!isTimedOut">
                        <textarea
                            v-model="checkOutRemarks"
                            placeholder="Enter remarks...."
                            class="mt-4 w-full p-2 border rounded text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#E64444]"
                            rows="3"
                        ></textarea>
                        <button
                            class="mt-4 w-full bg-[#5BD069] text-white text-base font-normal py-2 rounded hover:bg-red-700"
                            @click="confirmCheckOut"
                        >
                            Check Out
                        </button>
                    </template>
                </div>

                <!-- Schedule Card -->
                <div
                    class="bg-white p-6 rounded-lg shadow-md max-w-sm w-full sm:justify-self-end sm:mr-8 min-h-[200px]"
                >
                    <h2 class="text-lg font-bold text-[#E64444] mb-4">
                        Schedule
                    </h2>
                    <p class="text-sm text-gray-500">Standard Work Time:</p>
                    <p class="text-base font-semibold text-gray-800">
                        12:00 PM - 5:00 PM
                    </p>
                    <p class="text-sm text-gray-500 mt-2">Break Time:</p>
                    <p class="text-base font-semibold text-gray-800">
                        1-2 hour/s
                    </p>
                    <p class="text-sm text-gray-500 mt-2">Status:</p>
                    <p
                        class="text-base font-semibold text-gray-800 whitespace-nowrap"
                    >
                        {{
                            isTimedIn
                                ? isTimedOut
                                    ? "Timed Out"
                                    : "Timed In"
                                : "Not Timed In"
                        }}
                    </p>
                </div>
            </div>

            <!-- Attendance Record -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-[#E64444]">
                        Attendance Record
                    </h2>
                    <div class="relative">
                        <DateFilter v-model="selectedDate" />
                    </div>
                </div>

                <!-- Attendance Table -->
                <div class="overflow-x-auto bg-white shadow rounded-lg">
                    <table class="min-w-full text-sm text-gray-700">
                        <thead
                            class="bg-gray-100 text-xs uppercase text-gray-600"
                        >
                            <tr>
                                <th class="px-4 py-3 text-left">Remarks</th>
                                <th class="px-4 py-3 text-center">Date</th>
                                <th class="px-4 py-3 text-center">Time In</th>
                                <th class="px-4 py-3 text-center">Time Out</th>
                                <th class="px-4 py-3 text-center">Overtime</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(record, index) in filteredRecords"
                                :key="index"
                                class="border-b hover:bg-gray-50"
                            >
                                <td class="px-4 py-3 text-left">
                                    {{ record.remarks }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ record.date }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ record.timeIn }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ record.timeOut }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ record.overtime }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div
            v-if="showSuccessModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        >
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm text-center">
                <img
                    src="@/assets/success.png"
                    alt="Check In Success"
                    class="mx-auto w-20 mb-4"
                />
                <p class="text-lg font-semibold text-gray-700">
                    {{ isTimedOut ? "Check Out Success" : "Check In Success" }}
                </p>
                <button
                    @click="showSuccessModal = false"
                    class="mt-4 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import DateFilter from "@/Components/date-filter.vue";
import Sidebar from "@/Components/side-bar.vue";
import { Head } from "@inertiajs/vue3";

export default {
    name: "Attendance",
    components: {
        Sidebar,
        DateFilter,
        Head,
    },

    computed: {
        filteredRecords() {
            if (!this.selectedDate) return this.attendanceRecords;

            const selected = new Date(this.selectedDate)
                .toISOString()
                .split("T")[0];

            return this.attendanceRecords.filter(
                (record) => record.date === selected
            );
        },
    },
    data() {
        return {
            currentDate: "",
            currentTime: "",
            isTimedIn: false,
            isTimedOut: false,
            showSuccessModal: false,
            checkInTime: null,
            checkOutRemarks: "",
            intervalId: null,
            attendanceRecords: [],
            selectedDate: "",
        };
    },
    methods: {
        updateClock() {
            const now = new Date();
            this.currentDate = now.toLocaleDateString("en-US", {
                month: "short",
                day: "2-digit",
                year: "numeric",
            });
            this.currentTime = now.toLocaleTimeString([], {
                hour: "2-digit",
                minute: "2-digit",
            });
        },
        confirmCheckIn() {
            this.checkInTime = new Date();
            const numericDate = this.checkInTime.toISOString().split("T")[0];
            const formattedTime = this.checkInTime.toLocaleTimeString([], {
                hour: "2-digit",
                minute: "2-digit",
            });

            this.attendanceRecords.push({
                remarks: "-",
                date: numericDate,
                timeIn: formattedTime,
                timeOut: "-",
                overtime: "-",
            });

            this.isTimedIn = true;
            this.showSuccessModal = true;
        },
        confirmCheckOut() {
            const checkOutTime = new Date();
            const hoursWorked = Math.floor(
                (checkOutTime - this.checkInTime) / (1000 * 60 * 60)
            );
            const overtime =
                hoursWorked > 5 ? `${hoursWorked - 5} hour/s` : "0 hour/s";
            const formattedTime = checkOutTime.toLocaleTimeString([], {
                hour: "2-digit",
                minute: "2-digit",
            });

            const record =
                this.attendanceRecords[this.attendanceRecords.length - 1];
            record.timeOut = formattedTime;
            record.remarks = this.checkOutRemarks || "";
            record.overtime = overtime;

            this.checkOutRemarks = "";
            this.isTimedOut = true;
            this.showSuccessModal = true;
        },
    },
    mounted() {
        this.updateClock();
        this.intervalId = setInterval(this.updateClock, 1000);
    },
    beforeUnmount() {
        clearInterval(this.intervalId);
    },
};
</script>
