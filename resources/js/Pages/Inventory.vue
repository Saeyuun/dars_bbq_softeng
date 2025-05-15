<template>
    <div>
    <Head title="Inventory Management" />
        <Notification
            :show="showNotification"
            :type="notificationType"
            :message="notificationMessage"
            @close="showNotification = false"
        />
    <div class="flex flex-col sm:flex-row min-h-screen bg-gray-50">
        <div class="sm:hidden flex items-center justify-center p-4 bg-white shadow-md">
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
                <input v-model="searchQuery" type="text" placeholder="Search items..."
                        class="w-full sm:w-1/3 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-[#E64444]"
                        @input="searchItems" />
                <button @click="showAddItemModal = true"
                    class="w-full sm:w-auto bg-[#E64444] text-white px-4 py-2 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                    Add Item
                </button>
            </div>

            <!-- Responsive Table -->
            <div class="overflow-x-auto bg-white shadow rounded mb-4">
                <table class="min-w-full text-sm text-gray-700">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left">ID</th>
                            <th class="px-4 py-3 text-left">Log ID</th>
                            <th class="px-4 py-3 text-left">Item</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-right">Quantity</th>
                            <th class="px-4 py-3 text-left">Description</th>
                            <th class="px-4 py-3 text-left">Unit</th>
                            <th class="px-4 py-3 text-left">Date Updated</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr v-for="item in filteredItems" :key="item.item_id" class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">{{ item.item_id }}</td>
                                <td class="px-4 py-3 text-left">{{ item.inventory?.history?.[0]?.id || '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ item.item_name }}</td>
                            <td class="px-4 py-3 text-left">
                                    <span :class="{
                                        'px-2 py-1 rounded text-xs': true,
                                        'bg-green-100 text-green-800': item.inventory && item.inventory.status === 'available',
                                        'bg-red-100 text-red-800': item.inventory && item.inventory.status === 'out_of_stock'
                                    }">
                                        {{ item.inventory ? item.inventory.status : 'out_of_stock' }}
                                    </span>
                            </td>
                                <td class="px-4 py-3 text-right">{{ item.inventory ? item.inventory.quantity : 0 }}</td>
                                <td class="px-4 py-3 text-left">{{ item.description }}</td>
                                <td class="px-4 py-3 text-left">{{ item.unit }}</td>
                            <td class="px-4 py-3 text-left">
                                    {{ new Date(item.updated_at).toLocaleDateString() }}
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button class="text-gray-500 hover:text-[#E64444] focus:outline-none"
                                    @click="openEditModal(item)">
                                    Edit
                                </button>
                                <button class="text-gray-500 hover:text-[#E64444] focus:outline-none"
                                    @click="openUpdateStockModal(item)">
                                    Update
                                </button>
                                <button class="text-gray-500 hover:text-[#E64444] focus:outline-none"
                                    @click="openDeleteModal(item)">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

                <!-- Success Messages -->
                <div v-if="$page.props.flash.success" class="mt-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ $page.props.flash.success }}
            </div>
        </div>

        <!-- Add Item Modal -->
        <div v-if="showAddItemModal" class="fixed inset-0 bg-[#FFEDED]/70 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
                <button class="absolute top-2 right-2 text-gray-600 hover:text-[#E64444]"
                    @click="showAddItemModal = false">
                    ✕
                </button>
                <h2 class="text-xl font-semibold text-center text-[#E64444] mb-4">
                    Add Item
                </h2>
                    <form @submit.prevent="addItem" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Item Name</label>
                            <input v-model="newItem.item_name" type="text" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#E64444] focus:ring-[#E64444]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea v-model="newItem.description"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#E64444] focus:ring-[#E64444]"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Unit</label>
                            <select v-model="newItem.unit" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#E64444] focus:ring-[#E64444]">
                                <option value="">Select a unit</option>
                                <option value="kg">Kilogram (kg)</option>
                                <option value="g">Gram (g)</option>
                                <option value="l">Liter (L)</option>
                                <option value="ml">Milliliter (mL)</option>
                                <option value="pcs">Pieces (pcs)</option>
                                <option value="box">Box</option>
                                <option value="pack">Pack</option>
                                <option value="dozen">Dozen</option>
                                <option value="bottle">Bottle</option>
                                <option value="can">Can</option>
                                <option value="jar">Jar</option>
                                <option value="bag">Bag</option>
                                <option value="tray">Tray</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input v-model="newItem.inventory.quantity" type="number" required min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#E64444] focus:ring-[#E64444]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select v-model="newItem.inventory.status" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#E64444] focus:ring-[#E64444]">
                                <option value="available">Available</option>
                                <option value="out_of_stock">Out of Stock</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full bg-[#E64444] text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">
                            Add Item
                        </button>
                    </form>
            </div>
        </div>

        <!-- Edit Item Modal -->
        <div v-if="showEditItemModal" class="fixed inset-0 bg-[#FFEDED]/70 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
                <button class="absolute top-2 right-2 text-gray-600 hover:text-[#E64444]"
                    @click="showEditItemModal = false">
                    ✕
                </button>
                <h2 class="text-xl font-semibold text-center text-[#E64444] mb-4">
                    Edit Item
                </h2>
                    <form @submit.prevent="updateItem" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Item Name</label>
                            <input v-model="selectedItem.item_name" type="text" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#E64444] focus:ring-[#E64444]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea v-model="selectedItem.description"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#E64444] focus:ring-[#E64444]"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Unit</label>
                            <select v-model="selectedItem.unit" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#E64444] focus:ring-[#E64444]">
                                <option value="">Select a unit</option>
                                <option value="kg">Kilogram (kg)</option>
                                <option value="g">Gram (g)</option>
                                <option value="l">Liter (L)</option>
                                <option value="ml">Milliliter (mL)</option>
                                <option value="pcs">Pieces (pcs)</option>
                                <option value="box">Box</option>
                                <option value="pack">Pack</option>
                                <option value="dozen">Dozen</option>
                                <option value="bottle">Bottle</option>
                                <option value="can">Can</option>
                                <option value="jar">Jar</option>
                                <option value="bag">Bag</option>
                                <option value="tray">Tray</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full bg-[#E64444] text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">
                            Update Item
                        </button>
                    </form>
            </div>
        </div>

        <!-- Update Stock Modal -->
        <div v-if="showUpdateStockModal" class="fixed inset-0 bg-[#FFEDED]/70 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
                <button class="absolute top-2 right-2 text-gray-600 hover:text-[#E64444]"
                    @click="showUpdateStockModal = false">
                    ✕
                </button>
                <h2 class="text-xl font-semibold text-center text-[#E64444] mb-4">
                    Update Stock
                </h2>
                    <form @submit.prevent="updateStock" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Current Quantity</label>
                            <input v-model="selectedItem.inventory.quantity" type="number" required min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#E64444] focus:ring-[#E64444]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select v-model="selectedItem.inventory.status" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#E64444] focus:ring-[#E64444]">
                                <option value="available">Available</option>
                                <option value="out_of_stock">Out of Stock</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full bg-[#E64444] text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">
                            Update Stock
                        </button>
                    </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-[#FFEDED]/70 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
                <button class="absolute top-2 right-2 text-gray-600 hover:text-[#E64444]"
                    @click="showDeleteModal = false">
                    ✕
                </button>
                <h2 class="text-xl font-semibold text-center text-[#E64444] mb-4">
                    Delete Item
                </h2>
                <p class="text-center text-gray-600 mb-6">
                    Are you sure you want to delete this item?
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-2 sm:space-y-0 sm:space-x-4">
                        <button @click="deleteItem"
                        class="w-full sm:w-auto bg-[#E64444] text-white px-4 py-2 rounded hover:bg-red-600">
                        Delete
                    </button>
                    <button @click="showDeleteModal = false"
                        class="w-full sm:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Cancel
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Sidebar from "@/Components/side-bar.vue";
import InventoryHeader from "@/Components/Headers/inventory-header.vue";
import { Head, router } from "@inertiajs/vue3";
import { debounce } from 'lodash';
import Notification from '@/Components/Notification.vue';

export default {
    components: {
        Sidebar,
        InventoryHeader,
        Head,
        Notification,
    },
    props: {
        items: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            showAddItemModal: false,
            showEditItemModal: false,
            showUpdateStockModal: false,
            showDeleteModal: false,
            selectedItem: null,
            searchQuery: "",
            filteredItems: [],
            newItem: {
                item_name: '',
                description: '',
                unit: '',
                inventory: {
                    quantity: 0,
                    status: 'available'
                }
            },
            showNotification: false,
            notificationType: 'success',
            notificationMessage: '',
        };
    },
    watch: {
        items: {
            immediate: true,
            handler(newItems) {
                this.filteredItems = newItems;
            }
        }
    },
    methods: {
        searchItems() {
            if (!this.searchQuery.trim()) {
                this.filteredItems = this.items;
                return;
            }
            
            const searchTerm = this.searchQuery.toLowerCase();
            this.filteredItems = this.items.filter(item => 
                item.item_name.toLowerCase().includes(searchTerm)
            );
        },

        addItem() {
            const data = {
                item_name: this.newItem.item_name,
                description: this.newItem.description,
                unit: this.newItem.unit,
                inventory: {
                    quantity: this.newItem.inventory.quantity,
                    status: this.newItem.inventory.status
                },
                employee_id: this.$page.props.auth.user.employee_id
            };

            router.post(route('inventory.store'), data, {
                onSuccess: () => {
            this.showAddItemModal = false;
                    this.showNotification = true;
                    this.notificationType = 'success';
                    this.notificationMessage = 'Item added successfully';
                    // Reset the form
                    this.newItem = {
                        item_name: '',
                        description: '',
                        unit: '',
                        inventory: {
                            quantity: 0,
                            status: 'available'
                        }
                    };
                    setTimeout(() => {
                        this.showNotification = false;
                    }, 3000);
                },
                onError: (errors) => {
                    this.showNotification = true;
                    this.notificationType = 'error';
                    this.notificationMessage = 'Failed to add item';
            setTimeout(() => {
                        this.showNotification = false;
                    }, 3000);
                }
            });
        },

        openEditModal(item) {
            this.selectedItem = { 
                ...item,
                inventory: {
                    ...item.inventory,
                    quantity: item.inventory?.quantity || 0,
                    status: item.inventory?.status || 'out_of_stock'
                }
            };
            this.showEditItemModal = true;
        },

        updateItem() {
            const data = {
                item_name: this.selectedItem.item_name,
                description: this.selectedItem.description,
                unit: this.selectedItem.unit,
                inventory: {
                    quantity: this.selectedItem.inventory.quantity,
                    status: this.selectedItem.inventory.status
                }
            };

            router.put(route('inventory.update', this.selectedItem.item_id), data, {
                onSuccess: () => {
                    this.showEditItemModal = false;
                    this.showNotification = true;
                    this.notificationType = 'success';
                    this.notificationMessage = 'Item updated successfully';
                    setTimeout(() => {
                        this.showNotification = false;
                    }, 3000);
                },
                onError: (errors) => {
                    this.showNotification = true;
                    this.notificationType = 'error';
                    this.notificationMessage = 'Failed to update item';
                    setTimeout(() => {
                        this.showNotification = false;
                    }, 3000);
                }
            });
        },

        openUpdateStockModal(item) {
            this.selectedItem = { ...item };
            this.showUpdateStockModal = true;
        },

        updateStock() {
            const data = {
                inventory: {
                    quantity: this.selectedItem.inventory.quantity,
                    status: this.selectedItem.inventory.status
                }
            };

            router.put(route('inventory.update', this.selectedItem.item_id), data, {
                onSuccess: () => {
            this.showUpdateStockModal = false;
                    this.showNotification = true;
                    this.notificationType = 'success';
                    this.notificationMessage = 'Stock updated successfully';
                    setTimeout(() => {
                        this.showNotification = false;
                    }, 3000);
                },
                onError: (errors) => {
                    this.showNotification = true;
                    this.notificationType = 'error';
                    this.notificationMessage = 'Failed to update stock';
                    setTimeout(() => {
                        this.showNotification = false;
                    }, 3000);
                }
            });
        },

        openDeleteModal(item) {
            this.selectedItem = item;
            this.showDeleteModal = true;
        },

        deleteItem() {
            router.delete(route('inventory.destroy', this.selectedItem.item_id), {
                onSuccess: () => {
                    this.showDeleteModal = false;
                    this.showNotification = true;
                    this.notificationType = 'success';
                    this.notificationMessage = 'Item deleted successfully';
                    setTimeout(() => {
                        this.showNotification = false;
                    }, 3000);
                },
                onError: (errors) => {
                    this.showNotification = true;
                    this.notificationType = 'error';
                    this.notificationMessage = 'Failed to delete item';
                setTimeout(() => {
                        this.showNotification = false;
                    }, 3000);
                }
            });
        }
    }
};
</script>
