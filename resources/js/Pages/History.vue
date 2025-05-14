<template>
    <Head title="History" />
    <div class="flex flex-col sm:flex-row min-h-screen bg-gray-50">
        <!-- Sidebar only on screens >= sm -->
        <div class="hidden sm:block w-64 bg-white">
            <Sidebar />
        </div>

        <div class="flex-1 p-4 sm:p-5">
            <HistoryHeader />

            <div class="mb-4">
                <DateFilter @date-change="updateSelectedDate" />
            </div>

            <div class="flex flex-col lg:flex-row gap-4 mt-5">
                <div
                    class="w-full lg:flex-grow relative overflow-x-auto shadow-md sm:rounded-lg bg-white"
                >
                    <table class="min-w-full text-sm text-left text-gray-500">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-100 border-b border-gray-200"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">ID</th>
                                <th scope="col" class="px-6 py-3">Item</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">
                                    New Quantity
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Date Added
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="filteredItems.length > 0">
                                <template
                                    v-for="item in filteredItems"
                                    :key="item.id"
                                >
                                    <tr
                                        class="bg-white border-b border-gray-200 hover:bg-gray-50"
                                    >
                                        <th
                                            scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                        >
                                            {{ item.id }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ item.name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ item.status }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ item.newQuantity }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ item.dateAdded }}
                                        </td>
                                    </tr>
                                </template>
                            </template>
                            <tr v-else>
                                <td
                                    colspan="5"
                                    class="px-6 py-4 text-center text-gray-500"
                                >
                                    No items found for the selected date.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div
                    class="flex flex-col space-y-4 w-full lg:w-72 mt-4 lg:mt-0"
                >
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold">Low on Stock</h3>
                        <p class="text-sm text-gray-500">
                            On December 19, 2024
                        </p>
                        <p class="text-xl font-semibold mt-2">Garlic</p>
                        <p class="text-sm text-gray-500">2 Kg</p>
                        <button
                            class="mt-4 w-full bg-[#5BD069] text-white text-base font-normal py-2 rounded hover:bg-green-700"
                        >
                            Update
                        </button>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold">No Stock</h3>
                        <p class="text-sm text-gray-500">
                            On December 19, 2024
                        </p>
                        <p class="text-xl font-semibold mt-2">Eggs</p>
                        <button
                            class="mt-4 w-full bg-[#5BD069] text-white text-base font-normal py-2 rounded hover:bg-green-700"
                        >
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import HistoryHeader from "@/Components/Headers/history-header.vue";
import Sidebar from "@/Components/side-bar.vue";
import DateFilter from "@/Components/date-filter.vue";
import { Head } from "@inertiajs/vue3";
export default {
    name: "History",
    components: {
        HistoryHeader,
        Sidebar,
        DateFilter,
        Head,
    },
    data() {
        return {
            selectedDate: null,
            items: [
              
            ],
        };
    },
    computed: {
        filteredItems() {
            if (!this.selectedDate) {
                return this.items;
            }
            return this.items.filter(
                (item) => item.dateAdded === this.selectedDate
            );
        },
    },
    methods: {
        updateSelectedDate(date) {
            this.selectedDate = date;
        },
    },
};
</script>
