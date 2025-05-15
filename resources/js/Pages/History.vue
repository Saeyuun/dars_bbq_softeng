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

            <!-- Date Filter -->
            <div class="mb-4">
                <input type="date" v-model="dateFilter" 
                    class="w-full sm:w-1/3 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-[#E64444]">
            </div>

            <!-- History Table -->
            <div class="overflow-x-auto bg-white shadow rounded mb-4">
                <table class="min-w-full text-sm text-gray-700">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left">Date</th>
                            <th class="px-4 py-3 text-left">Item Name</th>
                            <th class="px-4 py-3 text-left">Action</th>
                            <th class="px-4 py-3 text-left">Quantity</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Updated By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="record in filteredHistory" :key="record.id" class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 text-left">
                                {{ new Date(record.created_at).toLocaleDateString() }}
                            </td>
                            <td class="px-4 py-3 text-left">{{ record.item_name }}</td>
                            <td class="px-4 py-3 text-left">
                                <span :class="{
                                    'px-2 py-1 rounded text-xs': true,
                                    'bg-green-100 text-green-800': record.action === 'added',
                                    'bg-blue-100 text-blue-800': record.action === 'updated',
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
                                    {{ record.status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-left">{{ record.employee_name }}</td>
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
            dateFilter: ''
        };
    },
    computed: {
        filteredHistory() {
            if (!this.dateFilter) return this.history;
            
            const filterDate = new Date(this.dateFilter);
            return this.history.filter(record => {
                const recordDate = new Date(record.created_at);
                return recordDate.toDateString() === filterDate.toDateString();
            });
        }
    }
};
</script>
