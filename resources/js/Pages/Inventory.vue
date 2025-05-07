<template>
    <Head title="Inventory Management" />
    <div class="flex flex-col sm:flex-row min-h-screen bg-gray-50">
        <div
            class="sm:hidden flex items-center justify-center p-4 bg-white shadow-md"
        >
            <h1 class="text-xl font-bold text-[#E64444]">Inventory</h1>
        </div>

        <div class="hidden sm:block w-64">
            <Sidebar />
        </div>

        <div class="flex-1 p-4">
            <div class="flex justify-between items-center mb-4">
                <InventoryHeader />
            </div>

            <div class="flex flex-col sm:flex-row gap-2 w-full mb-4">
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Search items..."
                    class="w-full sm:w-1/3 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-[#E64444]"
                />
                <button
                    @click="showAddItemModal = true"
                    class="w-full sm:w-auto bg-[#E64444] text-white px-4 py-2 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                >
                    Add Item
                </button>
            </div>

            <!-- Responsive Table: always visible, scrollable on mobile -->
            <div class="overflow-x-auto bg-white shadow rounded mb-4">
                <table class="min-w-full text-sm text-gray-700">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left">ID</th>
                            <th class="px-4 py-3 text-left">Item</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-right">Quantity</th>
                            <th class="px-4 py-3 text-left">Date Updated</th>
                            <th class="px-4 py-3 text-left">Description</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in filteredItems"
                            :key="item.id"
                            class="border-b hover:bg-gray-50"
                        >
                            <td class="px-4 py-3 text-left">{{ item.id }}</td>
                            <td class="px-4 py-3 text-left">{{ item.name }}</td>
                            <td class="px-4 py-3 text-left">
                                {{ item.status }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                {{ item.quantity }}
                            </td>
                            <td class="px-4 py-3 text-left">
                                {{ item.dateUpdated }}
                            </td>
                            <td class="px-4 py-3 text-left">
                                {{ item.description }}
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button
                                    class="text-gray-500 hover:text-[#E64444] focus:outline-none"
                                    @click="openEditModal(item)"
                                >
                                    Edit
                                </button>
                                <button
                                    class="text-gray-500 hover:text-[#E64444] focus:outline-none"
                                    @click="openUpdateStockModal(item)"
                                >
                                    Update
                                </button>
                                <button
                                    class="text-gray-500 hover:text-[#E64444] focus:outline-none"
                                    @click="openDeleteModal(item)"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View (optional, can be removed if you want only the table) -->
            <div class="sm:hidden space-y-4">
                <div
                    v-for="item in filteredItems"
                    :key="item.id"
                    class="bg-white rounded shadow p-4"
                >
                    <div class="flex justify-between items-center mb-2">
                        <div class="font-bold text-[#E64444]">
                            {{ item.name }}
                        </div>
                        <div class="text-xs text-gray-500">
                            ID: {{ item.id }}
                        </div>
                    </div>
                    <div class="text-sm mb-1">
                        <span class="font-semibold">Status:</span>
                        {{ item.status }}
                    </div>
                    <div class="text-sm mb-1">
                        <span class="font-semibold">Quantity:</span>
                        {{ item.quantity }}
                    </div>
                    <div class="text-sm mb-1">
                        <span class="font-semibold">Date:</span>
                        {{ item.dateUpdated }}
                    </div>
                    <!-- Description hidden on mobile for clarity -->
                    <div class="flex justify-end space-x-2 mt-2">
                        <button
                            class="text-gray-500 hover:text-[#E64444] focus:outline-none"
                            @click="openEditModal(item)"
                        >
                            Edit
                        </button>
                        <button
                            class="text-gray-500 hover:text-[#E64444] focus:outline-none"
                            @click="openUpdateStockModal(item)"
                        >
                            Update
                        </button>
                        <button
                            class="text-gray-500 hover:text-[#E64444] focus:outline-none"
                            @click="openDeleteModal(item)"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            <div
                v-if="deleteSuccessMessage"
                class="mt-4 p-4 bg-green-100 text-green-800 rounded"
            >
                {{ deleteSuccessMessage }}
            </div>
        </div>

        <!-- Add Item Modal -->
        <div
            v-if="showAddItemModal"
            class="fixed inset-0 bg-[#FFEDED]/70 flex items-center justify-center z-50"
        >
            <div
                class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative"
            >
                <button
                    class="absolute top-2 right-2 text-gray-600 hover:text-[#E64444]"
                    @click="showAddItemModal = false"
                >
                    ✕
                </button>
                <h2
                    class="text-xl font-semibold text-center text-[#E64444] mb-4"
                >
                    Add Item
                </h2>
                <AddItem @add-item="addItem" />
            </div>
        </div>

        <!-- Edit Item Modal -->
        <div
            v-if="showEditItemModal"
            class="fixed inset-0 bg-[#FFEDED]/70 flex items-center justify-center z-50"
        >
            <div
                class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative"
            >
                <button
                    class="absolute top-2 right-2 text-gray-600 hover:text-[#E64444]"
                    @click="showEditItemModal = false"
                >
                    ✕
                </button>
                <h2
                    class="text-xl font-semibold text-center text-[#E64444] mb-4"
                >
                    Edit Item
                </h2>
                <EditItem :item-data="selectedItem" @update-item="updateItem" />
            </div>
        </div>

        <!-- Update Stock Modal -->
        <div
            v-if="showUpdateStockModal"
            class="fixed inset-0 bg-[#FFEDED]/70 flex items-center justify-center z-50"
        >
            <div
                class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative"
            >
                <button
                    class="absolute top-2 right-2 text-gray-600 hover:text-[#E64444]"
                    @click="showUpdateStockModal = false"
                >
                    ✕
                </button>
                <h2
                    class="text-xl font-semibold text-center text-[#E64444] mb-4"
                >
                    Update Stock
                </h2>
                <UpdateStock
                    :item-data="selectedItem"
                    @update-stock="updateStock"
                />
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div
            v-if="showDeleteModal"
            class="fixed inset-0 bg-[#FFEDED]/70 flex items-center justify-center z-50"
        >
            <div
                class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative"
            >
                <button
                    class="absolute top-2 right-2 text-gray-600 hover:text-[#E64444]"
                    @click="showDeleteModal = false"
                >
                    ✕
                </button>
                <h2
                    class="text-xl font-semibold text-center text-[#E64444] mb-4"
                >
                    Delete Item
                </h2>
                <p class="text-center text-gray-600 mb-6">
                    Are you sure you want to delete this item?
                </p>
                <div
                    class="flex flex-col sm:flex-row justify-center space-y-2 sm:space-y-0 sm:space-x-4"
                >
                    <button
                        @click="confirmDelete"
                        class="w-full sm:w-auto bg-[#E64444] text-white px-4 py-2 rounded hover:bg-red-600"
                    >
                        Delete
                    </button>
                    <button
                        @click="showDeleteModal = false"
                        class="w-full sm:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Sidebar from "@/Components/side-bar.vue";
import InventoryHeader from "@/Components/Headers/inventory-header.vue";
import AddItem from "@/Components/add-item.vue";
import EditItem from "@/Components/edit-item.vue";
import UpdateStock from "@/Components/update-stock.vue";
import { Head } from "@inertiajs/vue3";

export default {
    components: {
        Sidebar,
        InventoryHeader,
        AddItem,
        EditItem,
        UpdateStock,
        Head,
    },
    data() {
        return {
            sidebarOpen: false,
            showAddItemModal: false,
            showEditItemModal: false,
            showUpdateStockModal: false,
            showDeleteModal: false,
            selectedItem: null,
            searchQuery: "",
            deleteSuccessMessage: "",

            // Partial data was initialized here for demonstration purposes
            items: [
                // {
                //     id: 1,
                //     name: "",
                //     status: "",
                //     quantity: "",
                //     dateUpdated: "",
                //     description: "",
                // },
                // {
                //     id: 2,
                //     name: "",
                //     status: "",
                //     quantity: "",
                //     dateUpdated: "",
                //     description: "",
                // },
                // {
                //     id: 3,
                //     name: "",
                //     status: "",
                //     quantity: "",
                //     dateUpdated: "",
                //     description: "",
                // },
            ],
        };
    },
    computed: {
        filteredItems() {
            return this.items.filter((item) =>
                item.name.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        },
        isWideScreen() {
            return window.innerWidth >= 640;
        },
    },
    methods: {
        addItem(item) {
            const newItem = {
                ...item,
                id: this.items.length + 1,
                dateUpdated: new Date().toISOString().split("T")[0],
            };
            this.items.push(newItem);
            this.showAddItemModal = false;
        },
        openEditModal(item) {
            this.selectedItem = { ...item };
            this.showEditItemModal = true;
        },
        updateItem(updated) {
            const index = this.items.findIndex((i) => i.id === updated.id);
            if (index !== -1) {
                this.items.splice(index, 1, updated);
            }
            this.showEditItemModal = false;
        },
        openUpdateStockModal(item) {
            this.selectedItem = { ...item };
            this.showUpdateStockModal = true;
        },
        updateStock(updated) {
            const index = this.items.findIndex((i) => i.id === updated.id);
            if (index !== -1) {
                this.items.splice(index, 1, updated);
            }
            this.showUpdateStockModal = false;
        },
        openDeleteModal(item) {
            this.selectedItem = item;
            this.showDeleteModal = true;
        },
        confirmDelete() {
            const index = this.items.findIndex(
                (i) => i.id === this.selectedItem.id
            );
            if (index !== -1) {
                this.items.splice(index, 1);
                this.deleteSuccessMessage = "Item successfully deleted!";
            }
            this.showDeleteModal = false;
            setTimeout(() => {
                this.deleteSuccessMessage = "";
            }, 1000);
        },
    },
};
</script>
