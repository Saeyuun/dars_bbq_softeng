<template>
    <Head title="History" />
    <div class="flex flex-col sm:flex-row min-h-screen bg-gray-50">
        <div class="sm:hidden flex items-center justify-center p-4 bg-white shadow-md">
            <h1 class="text-xl font-bold text-[#E64444]">History</h1>
        </div>

        <div class="hidden sm:block w-64">
            <Sidebar />
        </div>
        <div class="flex-1 p-4">
            <div class="flex justify-between items-center mb-4">
                <HistoryHeader />
            </div>

            <!-- Search and Filter -->
            <div class="mb-4 flex flex-col sm:flex-row gap-2">
                <select v-model="searchColumn" 
                    class="w-full sm:w-1/4 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-[#E64444]">
                    <option value="item_name">Item Name</option>
                    <option value="quantity">Quantity</option>
                    <option value="action">Action</option>
                    <option value="employee_name">Employee Name</option>
                </select>
                <input type="text" v-model="searchQuery" 
                    :placeholder="'Search by ' + searchColumn.replace('_', ' ')"
                    class="w-full sm:w-1/3 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-[#E64444]">
            </div>

            <!-- History Table -->
            <div class="overflow-x-auto bg-white shadow rounded mb-4">
                <table class="min-w-full text-sm text-gray-700 table-fixed">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                        <tr>
                            <th class="w-[100px] px-4 py-3 text-left">Log ID</th>
                            <th class="w-[180px] px-4 py-3 text-left">Date</th>
                            <th class="w-[200px] px-4 py-3 text-left">Item Name</th>
                            <th class="w-[120px] px-4 py-3 text-left">Action</th>
                            <th class="w-[100px] px-4 py-3 text-left">Quantity</th>
                            <th class="w-[120px] px-4 py-3 text-left">Status</th>
                            <th class="w-[150px] px-4 py-3 text-left">Updated By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="record in filteredHistory" :key="record.id" class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 text-left">{{ record.id }}</td>
                            <td class="px-4 py-3 text-left truncate">
                                {{ new Date(record.created_at).toLocaleString() }}
                            </td>
                            <td class="px-4 py-3 text-left truncate">{{ record.item_name }}</td>
                            <td class="px-4 py-3 text-left">
                                <span :class="{
                                    'px-2 py-1 rounded text-xs': true,
                                    'bg-green-100 text-green-800': record.action === 'added',
                                    'bg-blue-100 text-blue-800': record.action === 'updated' || record.action === 'updated to',
                                    'bg-red-100 text-red-800': record.action === 'deleted'
                                }">
                                    {{ record.action }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-left">{{ record.quantity }}</td>
                            <td class="px-4 py-3 text-left">
                                <span :class="{
                                    'px-2 py-1 rounded text-xs': true,
                                    'bg-green-100 text-green-800': record.status === 'available',
                                    'bg-red-100 text-red-800': record.status === 'out_of_stock'
                                }">
                                    {{ record.status === 'out_of_stock' ? 'Out of Stock' : 'Available' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-left truncate">{{ record.employee_name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import Sidebar from "@/Components/side-bar.vue";
import HistoryHeader from "@/Components/Headers/history-header.vue";
import { Head } from "@inertiajs/vue3";

export default {
    components: {
        Sidebar,
        HistoryHeader,
        Head,
    },
    props: {
        history: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            searchQuery: '',
            searchColumn: 'item_name'
        };
    },
    computed: {
        filteredHistory() {
            if (!this.searchQuery.trim()) return this.history;
            
            const searchTerm = this.searchQuery.toLowerCase();
            return this.history.filter(record => {
                const value = record[this.searchColumn];
                if (this.searchColumn === 'quantity') {
                    return value.toString().includes(searchTerm);
                }
                return value.toLowerCase().includes(searchTerm);
            });
        }
    }
};
</script>
