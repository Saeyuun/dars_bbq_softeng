<template>
  <SidebarEmployee />
  <InventoryHeader />

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
        @click="showAddItemModal = true"
      >
        Add Item
      </button>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white">
      <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b border-gray-200">
          <tr>
            <th scope="col" class="px-6 py-3">ID</th>
            <th scope="col" class="px-6 py-3">Item</th>
            <th scope="col" class="px-6 py-3">Status</th>
            <th scope="col" class="px-6 py-3">Quantity</th>
            <th scope="col" class="px-6 py-3">Date Updated</th>
            <th scope="col" class="px-6 py-3">Description</th>
            <th scope="col" class="px-6 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="item in filteredItems" :key="item.id">
            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
              <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                {{ item.id }}
              </td>
              <td class="px-6 py-4">{{ item.name }}</td>
              <td class="px-6 py-4">{{ item.status }}</td>
              <td class="px-6 py-4">{{ item.quantity }}</td>
              <td class="px-6 py-4">{{ item.dateUpdated }}</td>
              <td class="px-6 py-4">{{ item.description }}</td>
              <td class="px-6 py-4 text-right">
                <button
                  class="text-gray-500 hover:text-[#E64444] focus:outline-none"
                  @click="openEditModal(item)"
                >
                  Edit
                </button>
                <button
                  class="ml-2 text-gray-500 hover:text-[#E64444] focus:outline-none"
                  @click="openUpdateStockModal(item)"
                >
                  Update
                </button>
                <button
                  class="ml-2 text-gray-500 hover:text-red-600 focus:outline-none"
                  @click="deleteItem(item.id)"
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

  
  <!-- Add Item Modal -->
  <div
    v-if="showAddItemModal"
    class="fixed inset-0 bg-[#FFEDED] bg-opacity-50 flex items-center justify-center z-50"
  >
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
      <button
        class="absolute top-2 right-2 text-gray-500 hover:text-[#E64444] focus:outline-none"
        @click="showAddItemModal = false"
      >
        ✕
      </button>
      <h2 class="text-xl font-bold text-center text-[#E64444] mb-4">
        Add Item
      </h2>
      <AddItem @add-item="addItem" />
    </div>
  </div>

  <!-- Edit Item Modal -->
  <div
    v-if="showEditItemModal"
    class="fixed inset-0 bg-[#FFEDED] bg-opacity-50 flex items-center justify-center z-50"
  >
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
      <button
        class="absolute top-2 right-2 text-gray-500 hover:text-[#E64444] focus:outline-none"
        @click="showEditItemModal = false"
      >
        ✕
      </button>
      <h2 class="text-xl font-bold text-center text-[#E64444] mb-4">
        Edit Item
      </h2>
      <EditItem :item-data="selectedItem" @update-item="updateItem" />
    </div>
  </div>

  <!-- Update Stock Modal -->
  <div
    v-if="showUpdateStockModal"
    class="fixed inset-0 bg-[#FFEDED] bg-opacity-50 flex items-center justify-center z-50"
  >
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
      <button
        class="absolute top-2 right-2 text-gray-500 hover:text-[#E64444] focus:outline-none"
        @click="showUpdateStockModal = false"
      >
        ✕
      </button>

      <h2 class="text-xl font-bold text-center text-[#E64444] mb-4">
        Update Stock
      </h2>
      <UpdateStock :item-data="selectedItem" @update-stock="updateStock" />
    </div>
  </div>
</template>

<script>
import InventoryHeader from "@/components/Headers/inventory-header.vue";
import SidebarEmployee from "@/components/side-bar-employee.vue";
import AddItem from "@/components/add-item.vue";
import EditItem from "@/components/edit-item.vue";
import UpdateStock from "@/components/update-stock.vue";

export default {
  name: "Inventory",
  components: {
    SidebarEmployee,
    InventoryHeader,
    AddItem,
    EditItem,
    UpdateStock,
  },
  data() {
    return {
      searchQuery: "",
      showAddItemModal: false,
      showEditItemModal: false,
      showUpdateStockModal: false,
      selectedItem: null,
      items: [
        {
          id: 1,
          name: "Manok",
          status: "Available",
          quantity: 10,
          dateUpdated: "2023-04-01",
          description: "---",
        },
        {
          id: 2,
          name: "Barbeque Chicken",
          status: "Available",
          quantity: 15,
          dateUpdated: "2023-03-28",
          description: "--",
        },
        {
          id: 3,
          name: "Pork Belly",
          status: "Out of Stock",
          quantity: 0,
          dateUpdated: "2023-03-15",
          description: "---",
        },
      ],
    };
  },
  computed: {
    filteredItems() {
      return this.items.filter((item) =>
        item.name.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
  },
  methods: {
    addItem(newItem) {
      const newId = this.items.length + 1;
      this.items.push({ ...newItem, id: newId, dateUpdated: new Date().toISOString().split("T")[0] });
      this.showAddItemModal = false;
    },
    openEditModal(item) {
      this.selectedItem = { ...item };
      this.showEditItemModal = true;
    },
    updateItem(updatedItem) {
      const index = this.items.findIndex((item) => item.id === updatedItem.id);
      if (index !== -1) {
        this.items.splice(index, 1, updatedItem);
      }
      this.showEditItemModal = false;
    },
    openUpdateStockModal(item) {
      this.selectedItem = { ...item };
      this.showUpdateStockModal = true;
    },
    updateStock(updatedStock) {
      const index = this.items.findIndex((item) => item.id === updatedStock.id);
      if (index !== -1) {
        this.items[index].quantity = updatedStock.quantity;
        this.items[index].dateUpdated = new Date().toISOString().split("T")[0];
      }
      this.showUpdateStockModal = false;
    },
    deleteItem(itemId) {
      const confirmDelete = confirm("Delete this item?");
      if (confirmDelete) {
        this.items = this.items.filter((item) => item.id !== itemId);
        alert("Item deleted successfully.");
      }
    },
  },
};
</script>