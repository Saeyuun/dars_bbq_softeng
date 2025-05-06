<template>
    <div
        class="p-6 -mt-13 bg-gradient-to-b from-gray-100 to-gray-200 rounded-2xl shadow-lg"
    >
        <h3 class="text-xl font-semibold text-zinc-400 mb-2 -ml-170">
            Statistics
        </h3>
        <h4
            class="text-[#732222] font-semibold font-inter text-[25px] leading-[42.9px] mb-4 -ml-157"
        >
            Sales report
        </h4>

        <!-- Buttons -->
        <div class="flex justify-end mb-4 space-x-2">
            <button
                @click="showTableModal = true"
                class="ml-2 rounded-md bg-[#E64444] px-4 py-2 text-sm font-semibold text-white shadow transition duration-200 ease-in-out hover:bg-[#c33] hover:scale-105 focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-[#E64444] -mt-14"
            >
                View Sales and Cost
            </button>
            <button
                @click="showTableModal = false"
                class="ml-2 rounded-md bg-[#E64444] px-4 py-2 text-sm font-semibold text-white shadow transition duration-200 ease-in-out hover:bg-[#c33] hover:scale-105 focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-[#E64444] -mt-14"
            >
                View Yearly Report
            </button>
        </div>

        <!-- Chart -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <canvas id="myChart"></canvas>
        </div>

        <div class="flex justify-center space-x-4 mt-4">
            <button
                v-for="option in toggleOptions"
                :key="option.value"
                :class="[
                    'px-4 py-2 rounded-full text-sm font-semibold',
                    selectedOption === option.value
                        ? 'bg-[#E64444] text-white'
                        : 'bg-[#F5F5F5] text-[#1F1F1F]',
                ]"
                @click="selectedOption = option.value"
            >
                {{ option.label }}
            </button>
        </div>

        <!-- Sales and Cost Table Modal -->
        <div
            v-if="showTableModal"
            class="fixed inset-0 bg-[#FFEDED] bg-opacity-50 flex justify-center items-center z-50"
        >
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-5xl w-full">
                <!-- Close Button -->
                <button
                    @click="showTableModal = false"
                    class="absolute top-2 right-2 text-gray-500 hover:text-[#E64444] focus:outline-none"
                >
                    ✕
                </button>

                <!-- Sales and Costs Tables -->
                <div class="grid grid-cols-1 gap-6">
                    <!-- Sales Report Table -->
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-[#732222]">
                                Sales Report
                            </h3>
                            <DateFilter v-model="salesDateFilter" />
                        </div>
                        <table
                            class="min-w-full text-sm text-left text-gray-500 border border-gray-200 rounded-lg"
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-100 border-b border-gray-200"
                            >
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Order ID
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total Price
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Created At
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Created By
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <template
                                    v-for="sale in filteredSalesData"
                                    :key="sale.id"
                                >
                                    <tr
                                        class="bg-white border-b border-gray-200 hover:bg-gray-50"
                                    >
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                        >
                                            {{ sale.id }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ sale.totalPrice }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ sale.date }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ sale.createdBy }}
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <!-- Costs Report Table -->
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-[#732222]">
                                Costs Report
                            </h3>
                            <DateFilter v-model="costsDateFilter" />
                        </div>
                        <table
                            class="min-w-full text-sm text-left text-gray-500 border border-gray-200 rounded-lg"
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-100 border-b border-gray-200"
                            >
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Cost ID
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total Price
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Created At
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Created By
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <template
                                    v-for="cost in filteredCostsData"
                                    :key="cost.id"
                                >
                                    <tr
                                        class="bg-white border-b border-gray-200 hover:bg-gray-50"
                                    >
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                        >
                                            {{ cost.id }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ cost.totalPrice }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ cost.date }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ cost.createdBy }}
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Chart from "chart.js/auto";
import DateFilter from "../date-filter.vue";

export default {
    name: "SalesReportChart",
    components: {
        DateFilter,
    },
    data() {
        return {
            chart: null,
            showTableModal: false,
            salesDateFilter: "",
            costsDateFilter: "",
            selectedOption: "7-days", // Default
            toggleOptions: [
                { label: "7 days", value: "7-days" },
                { label: "30 days", value: "30-days" },
                { label: "12 months", value: "12-months" },
            ],
            salesData: [
                {
                    id: 1299,
                    totalPrice: 200,
                    date: "2024-12-19",
                    createdBy: "Karina",
                },
                {
                    id: 1298,
                    totalPrice: 300,
                    date: "2024-12-19",
                    createdBy: "Karina",
                },
                {
                    id: 1297,
                    totalPrice: 50,
                    date: "2024-12-19",
                    createdBy: "Karina",
                },
                {
                    id: 1296,
                    totalPrice: 150,
                    date: "2024-12-19",
                    createdBy: "Karina",
                },
            ],
            costsData: [
                {
                    id: 751,
                    totalPrice: 1071,
                    date: "2024-12-15",
                    createdBy: "Karina",
                },
                {
                    id: 750,
                    totalPrice: 500,
                    date: "2024-12-12",
                    createdBy: "Karina",
                },
                {
                    id: 749,
                    totalPrice: 851,
                    date: "2024-12-10",
                    createdBy: "Karina",
                },
                {
                    id: 748,
                    totalPrice: 254,
                    date: "2024-12-05",
                    createdBy: "Winter",
                },
            ],
        };
    },
    computed: {
        filteredSalesData() {
            if (!this.salesDateFilter) return this.salesData;
            return this.salesData.filter(
                (sale) => sale.date === this.salesDateFilter
            );
        },
        filteredCostsData() {
            if (!this.costsDateFilter) return this.costsData;
            return this.costsData.filter(
                (cost) => cost.date === this.costsDateFilter
            );
        },
    },
    mounted() {
        const ctx = document.getElementById("myChart").getContext("2d");
        this.chart = new Chart(ctx, {
            type: "line",
            data: {
                labels: [
                    "JAN",
                    "FEB",
                    "MAR",
                    "APR",
                    "MAY",
                    "JUN",
                    "JUL",
                    "AUG",
                    "SEP",
                    "OCT",
                    "NOV",
                    "DEC",
                ],
                datasets: [
                    {
                        label: "Total Sales",
                        data: [0, 200000],
                        borderColor: "purple",
                        borderWidth: 2,
                        tension: 0.4,
                        borderDash: [],
                    },
                    {
                        label: "Total Cost",
                        data: [0, 100000],
                        borderColor: "red",
                        borderWidth: 2,
                        tension: 0.4,
                        borderDash: [5, 5],
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: "top",
                        labels: {
                            usePointStyle: true,
                        },
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return value >= 1000000
                                    ? value / 1000000 + "M"
                                    : value / 1000 + "k";
                            },
                        },
                    },
                },
            },
        });
    },
    beforeDestroy() {
        if (this.chart) {
            this.chart.destroy();
        }
    },
};
</script>

<style scoped>
canvas {
    max-width: 100%;
    height: auto;
}
button {
    transition: all 0.2s ease-in-out;
}
button:hover {
    transform: scale(1.05);
}
</style>
