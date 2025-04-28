<template>
  <SideBarOwner />
  <div class="p-4">
    <div class="flex justify-between items-center mb-4">
      <div class="relative">
        <input
          type="text"
          placeholder="Search..."
          class="w-64 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#E64444]"
          v-model="searchQuery"
        />
      </div>
      <button
        class="ml-2 rounded-md bg-[#E64444] px-4 py-2 text-sm font-semibold text-white shadow transition duration-200 ease-in-out hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400"
        @click="showAddEmployeeModal = true"
      >
        Add Employee Record
      </button>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white">
      <table class="w-full text-sm text-left text-gray-500">
        <thead
          class="text-xs text-gray-700 uppercase bg-gray-100 border-b border-gray-200"
        >
          <tr>
            <th scope="col" class="px-6 py-3">Employee ID</th>
            <th scope="col" class="px-6 py-3">Name</th>
            <th scope="col" class="px-6 py-3">Email</th>
            <th scope="col" class="px-6 py-3">Role</th>
            <th scope="col" class="px-6 py-3">Contact No.</th>
            <th scope="col" class="px-6 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="employee in filteredEmployees" :key="employee.id">
            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
              <!-- Employee ID -->
              <td class="px-6 py-4">{{ employee.id }}</td>

              <!-- Name -->
              <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                <div class="flex items-center space-x-3">
                  <img
                    :src="employee.avatar"
                    alt="Avatar"
                    class="w-8 h-8 rounded-full"
                  />
                  <span>{{ employee.name }}</span>
                </div>
              </td>
              <!-- Email -->
              <td class="px-6 py-4">{{ employee.email }}</td>
              <!-- Role -->
              <td class="px-6 py-4">{{ employee.role }}</td>

              <!-- Contact Number -->
              <td class="px-6 py-4">{{ employee.contact }}</td>

              <!-- Actions -->
              <td class="px-6 py-4 text-right">
                <button
                  class="text-gray-500 hover:text-[#E64444] focus:outline-none"
                  @click="openEditModal(employee)"
                >
                  Edit
                </button>
                <button
                  class="ml-4 text-gray-500 hover:text-red-600 focus:outline-none"
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

  

  <!-- Modals Diri na part -->




  <!-- Add Employee Modal -->
  <div
    v-if="showAddEmployeeModal"
    class="fixed inset-0 bg-[#FFEDED] bg-opacity-50 flex items-center justify-center z-50"
  >
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
      <button
        class="absolute top-2 right-2 text-gray-500 hover:text-[#E64444] focus:outline-none"
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

 
  <!-- Edit Employee Modal -->
<div
  v-if="showEditEmployeeModal"
  class="fixed inset-0 bg-[#FFEDED] bg-opacity-50 flex items-center justify-center z-50"
>
  <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
    <button
      class="absolute top-2 right-2 text-gray-500 hover:text-[#E64444] focus:outline-none"
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

<!-- Delete Employee Modal -->
<div
  v-if="showDeleteEmployeeModal"
  class="fixed inset-0 bg-[#FFEDED] bg-opacity-50 flex items-center justify-center z-50"
>
  <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
    <button
      class="absolute top-2 right-2 text-gray-500 hover:text-[#E64444] focus:outline-none"
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
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full text-center">
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
        <h2 class="text-lg font-bold text-gray-800">Employee Deleted</h2>
      </div>
    </div>
  </div>
</template>

<script>
import SideBarOwner from "@/components/side-bar-owner.vue";
import AddEmployeeRecord from "../components/add-employee-record.vue";
import EditEmployeeRecord from "../components/edit-employee.vue";
import DeleteEmployee from "../components/delete-employee.vue";

export default {
  name: "Employees",
  components: {
    SideBarOwner,
    AddEmployeeRecord,
    EditEmployeeRecord,
    DeleteEmployee,
  },
  data() {
    return {
      searchQuery: "",
      showAddEmployeeModal: false,
      showEditEmployeeModal: false,
      showDeleteEmployeeModal: false,
      showDeleteSuccess: false,
      selectedEmployee: null,
      newEmployee: {
        name: "",
        role: "",
        contact: "",
      },
      employees: [
        {
          id: 1,
          name: "Jennie",
          email: "jennie.bp@gmail.com",
          role: "Cashier",
          contact: "+6309019311",
          avatar: "https://placehold.co/40x40",
        },
        {
          id: 2,
          name: "Karina",
          email: "karina.bp@gmail.com",
          role: "Cashier",
          contact: "+6387653912",
          avatar: "https://placehold.co/40x40",
        },
        {
          id: 3,
          name: "Lisa",
          email: "lisa.bp@gmail.com",
          role: "Sales Clerk",
          contact: "+639058604",
          avatar: "https://placehold.co/40x40",
        },
      ],
    };
  },
  computed: {
    filteredEmployees() {
      return this.employees.filter((employee) =>
        employee.name.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
  },
  methods: {
    addEmployee(employeeData) {
      const newId = this.employees.length + 1;
      this.employees.push({
        ...employeeData,
        id: newId,
        avatar: "https://placehold.co/40x40",
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
    deleteEmployee(employeeId) {
  this.employees = this.employees.filter(
    (employee) => employee.id !== employeeId
  );
  this.showDeleteEmployeeModal = false;
  this.showDeleteSuccess = true;
  setTimeout(() => {
    this.showDeleteSuccess = false;
  }, 3000);
},
  },
};
</script>
