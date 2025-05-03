<template>
    <div class="flex min-h-screen">
        <SideBarOwner />
        <div class="flex-1 p-4 ml-[250px]">
            <!-- Search bar and Add button -->
            <div class="flex justify-between items-center mb-4">
                <!-- Search bar and Search button -->
                <div class="flex items-center gap-2">
                    <input
                        type="text"
                        placeholder="Search..."
                        class="w-64 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#E64444]"
                        v-model="searchQuery"
                    />
                    <button
                        class="rounded-md bg-[#E64444] px-3 py-2 text-sm text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400"
                        @click="toggleAttendance"
                    >
                        Search Employee
                    </button>
                </div>

                <!-- Add Employee Button -->
                <button
                    class="rounded-md bg-[#E64444] px-4 py-2 text-sm font-semibold text-white shadow transition duration-200 ease-in-out hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                    @click="showAddEmployeeModal = true"
                >
                    Add Employee Record
                </button>
            </div>

            <!-- Employee Table -->
            <div
                class="relative overflow-x-auto max-w-full shadow-md sm:rounded-lg bg-white"
            >
                <table
                    class="min-w-[640px] w-full text-sm text-left text-gray-500"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-100 border-b border-gray-200"
                    >
                        <tr>
                            <th class="px-6 py-3">Employee ID</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Contact No.</th>
                            <th class="px-6 py-3">Position</th>
                            <th class="px-6 py-3">Address</th>
                            <th class="px-6 py-3">Hire Date</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template
                            v-for="employee in filteredEmployees"
                            :key="employee.id"
                        >
                            <tr
                                class="bg-white border-b border-gray-200 hover:bg-gray-50"
                            >
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ employee.id }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    <div class="flex items-center space-x-3">
                                        <img
                                            :src="employee.avatar"
                                            alt="Avatar"
                                            class="w-8 h-8 rounded-full"
                                        />
                                        <span>{{ employee.name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">{{ employee.email }}</td>
                                <td class="px-6 py-4">
                                    {{ employee.contact }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ employee.position }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ employee.address }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ employee.hireDate }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button
                                        class="text-gray-500 hover:text-[#E64444]"
                                        @click="openEditModal(employee)"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        class="ml-4 text-gray-500 hover:text-red-600"
                                        @click="openDeleteModal(employee)"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div
        v-if="showAddEmployeeModal"
        class="fixed inset-0 bg-[#FFEDED] bg-opacity-50 flex items-center justify-center z-50"
    >
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
            <button
                class="absolute top-2 right-2 text-gray-500 hover:text-[#E64444]"
                @click="showAddEmployeeModal = false"
            >
                ✕
            </button>
            <h2 class="text-xl font-bold text-center text-[#E64444] mb-4">
                Employee Details
            </h2>
            <AddEmployeeRecord @add-employee="addEmployee" />
        </div>
    </div>

    <div
        v-if="showEditEmployeeModal"
        class="fixed inset-0 bg-[#FFEDED] bg-opacity-50 flex items-center justify-center z-50"
    >
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
            <button
                class="absolute top-2 right-2 text-gray-500 hover:text-[#E64444]"
                @click="showEditEmployeeModal = false"
            >
                ✕
            </button>
            <h2 class="text-xl font-bold text-center text-[#E64444] mb-4">
                Edit Employee
            </h2>
            <EditEmployeeRecord
                :employee="selectedEmployee"
                @edit-employee="editEmployee"
            />
        </div>
    </div>

    <div
        v-if="showDeleteEmployeeModal"
        class="fixed inset-0 bg-[#FFEDED] bg-opacity-50 flex items-center justify-center z-50"
    >
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
            <button
                class="absolute top-2 right-2 text-gray-500 hover:text-[#E64444]"
                @click="showDeleteEmployeeModal = false"
            >
                ✕
            </button>
            <h2 class="text-xl font-bold text-center text-[#E64444] mb-4">
                Delete Employee
            </h2>
            <DeleteEmployee
                :show="showDeleteEmployeeModal"
                :employee="selectedEmployee"
                @close="showDeleteEmployeeModal = false"
                @delete="deleteEmployee"
            />
        </div>
    </div>

    <div
        v-if="showDeleteSuccess"
        class="fixed inset-0 bg-[#FFEDED] bg-opacity-50 flex items-center justify-center z-50"
    >
        <div
            class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full text-center"
        >
            <div class="flex flex-col items-center">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-16 w-16 text-red-500 mb-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                <h2 class="text-lg font-bold text-gray-800">
                    Employee Deleted
                </h2>
            </div>
        </div>
    </div>

    <!-- Search Result Modal -->
    <div
        v-if="showAttendanceModal"
        class="fixed inset-0 bg-[#FFEDED] bg-opacity-50 flex items-center justify-center z-50"
    >
        <div
            class="bg-white p-6 rounded-lg shadow-lg max-w-5xl w-full relative"
        >
            <button
                class="absolute top-2 right-2 text-gray-500 hover:text-[#E64444]"
                @click="showAttendanceModal = false"
            >
                ✕
            </button>
            <h2 class="text-xl font-bold text-center text-[#E64444] mb-4">
                {{ searchQuery }}
            </h2>
            <EmployeeRecord :employees="filteredEmployees" />
        </div>
    </div>
</template>

<script>
import SideBarOwner from "@/Components/side-bar-owner.vue";
import AddEmployeeRecord from "../Components/add-employee-record.vue";
import EditEmployeeRecord from "../Components/edit-employee.vue";
import DeleteEmployee from "../Components/delete-employee.vue";
import EmployeeRecord from "../Components/TablesandCharts/employee-record.vue";

export default {
    name: "Employees",
    components: {
        SideBarOwner,
        AddEmployeeRecord,
        EditEmployeeRecord,
        DeleteEmployee,
        EmployeeRecord,
    },
    data() {
        return {
            searchQuery: "",
            showAddEmployeeModal: false,
            showEditEmployeeModal: false,
            showDeleteEmployeeModal: false,
            showDeleteSuccess: false,
            showAttendanceModal: false,
            selectedEmployee: null,
            employees: [
                // {
                //     id: 1,
                //     name: "",
                //     email: "",
                //     position: "",
                //     contact: "",
                //     address: "",
                //     hireDate: "",
                //     avatar: "",
                // },
                // {
                //     id: 2,
                //     name: "",
                //     email: "",
                //     position: "",
                //     contact: "",
                //     address: "",
                //     hireDate: "",
                //     avatar: "",
                // },
                // {
                //     id: 2,
                //     name: "",
                //     email: "",
                //     position: "",
                //     contact: "",
                //     address: "",
                //     hireDate: "",
                //     avatar: "",
                // },
            ],
        };
    },
    computed: {
        filteredEmployees() {
            return this.employees.filter((employee) =>
                employee.name
                    .toLowerCase()
                    .includes(this.searchQuery.toLowerCase())
            );
        },
    },
    methods: {
        toggleAttendance() {
            this.showAttendanceModal = true;
        },
        addEmployee(employeeData) {
            const newId = this.employees.length + 1;
            const avatarUrl =
                employeeData.profilePicture || "https://placehold.co/40x40";
            const hireDate = new Date().toLocaleDateString();

            this.employees.push({
                ...employeeData,
                id: newId,
                avatar: avatarUrl,
                hireDate,
            });

            this.showAddEmployeeModal = false;
        },
        openEditModal(employee) {
            this.selectedEmployee = employee;
            this.showEditEmployeeModal = true;
        },
        openDeleteModal(employee) {
            this.selectedEmployee = employee;
            this.showDeleteEmployeeModal = true;
        },
        editEmployee(updatedEmployee) {
            const index = this.employees.findIndex(
                (emp) => emp.id === updatedEmployee.id
            );
            if (index !== -1) {
                this.employees.splice(index, 1, updatedEmployee);
            }
            this.showEditEmployeeModal = false;
        },
        deleteEmployee(employeeId) {
            this.employees = this.employees.filter(
                (employee) => employee.id !== employeeId
            );
            this.showDeleteEmployeeModal = false;
            this.showDeleteSuccess = true;
            setTimeout(() => {
                this.showDeleteSuccess = false;
            }, 1100);
        },
    },
};
</script>
