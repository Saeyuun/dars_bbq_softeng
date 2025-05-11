<template>
    <div
        class="max-w-5xl mx-auto w-full p-4 sm:p-6 lg:p-8 bg-gradient-to-b from-gray-100 to-gray-200 rounded-2xl shadow-lg mt-6"
    >
        <h3 class="text-xl font-semibold text-zinc-400 mb-1">Statistics</h3>
        <h4
            class="text-[#732222] font-semibold font-inter text-2xl leading-tight mb-4"
        >
            Sales report
        </h4>

        <div class="flex justify-end mb-4 space-x-2">
            <button
                @click="showTableModal = true"
                class="ml-2 rounded-md bg-[#E64444] px-4 py-2 text-sm font-semibold text-white shadow transition duration-200 ease-in-out hover:bg-[#c33] hover:scale-105 focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-[#E64444] -mt-14"
            >
                View Sales and Cost
            </button>
        </div>

        <div
            class="bg-white shadow-md rounded-lg p-4 max-w-3xl mx-auto h-80 flex items-center justify-center"
        >
            <canvas id="myChart" class="w-full h-full"></canvas>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 mt-8 justify-center">
            <div
                class="flex-1 bg-white rounded-2xl shadow p-6 min-w-[250px] max-w-xs mx-auto"
            >
                <div class="text-sm text-gray-400 font-semibold mb-1">
                    Yearly Report
                </div>
                <div class="text-lg font-bold text-gray-900 mb-1">
                    Chicken Toppings Sale
                </div>
                <div class="flex items-end gap-4">
                    <div>
                        <div
                            class="text-4xl font-extrabold text-gray-900 leading-none"
                        >
                            635
                        </div>
                        <div class="text-green-500 font-semibold text-sm mt-1">
                            +21.01%
                        </div>
                    </div>
                    <canvas
                        id="chickenToppingsChart"
                        class="w-24 h-16"
                    ></canvas>
                </div>
            </div>

            <div
                class="flex-1 bg-white rounded-2xl shadow p-6 min-w-[250px] max-w-xs mx-auto"
            >
                <div class="text-sm text-gray-400 font-semibold mb-1">
                    Yearly Report
                </div>
                <div class="text-lg font-bold text-gray-900 mb-1">
                    Pork Toppings Sale
                </div>
                <div class="flex items-end gap-4">
                    <div>
                        <div
                            class="text-4xl font-extrabold text-gray-900 leading-none"
                        >
                            325
                        </div>
                        <div class="text-green-500 font-semibold text-sm mt-1">
                            +18.34%
                        </div>
                    </div>
                    <canvas id="porkToppingsChart" class="w-24 h-16"></canvas>
                </div>
            </div>
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

        <div
            v-if="showTableModal"
            class="fixed inset-0 bg-[#FFEDED] bg-opacity-50 flex justify-center items-center z-50"
        >
            <div
                class="bg-white p-6 rounded-lg shadow-lg max-w-5xl w-full relative"
            >
                <button
                    @click="showTableModal = false"
                    class="absolute top-2 right-2 text-gray-500 hover:text-[#E64444] focus:outline-none text-2xl"
                >
                    ✕
                </button>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-lg font-semibold text-[#732222]">
                                Sales Report
                            </h3>
                            <DateFilter v-model="salesDateFilter" />
                        </div>
                        <SalesReportTable :filter-date="salesDateFilter" />
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-lg font-semibold text-[#732222]">
                                Costs Report
                            </h3>
                            <DateFilter v-model="costsDateFilter" />
                        </div>
                        <CostsReportTable :filter-date="costsDateFilter" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Chart from "chart.js/auto";
import DateFilter from "../date-filter.vue";
import SalesReportTable from "./sales-report-table.vue";
import CostsReportTable from "./costs-report-table.vue";

export default {
    name: "SalesReportChart",
    components: {
        DateFilter,
        SalesReportTable,
        CostsReportTable,
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
        // Main chart
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
        // Chicken Toppings mini chart
        const chickenCtx = document
            .getElementById("chickenToppingsChart")
            .getContext("2d");
        new Chart(chickenCtx, {
            type: "line",
            data: {
                labels: Array.from({ length: 10 }, (_, i) => i + 1),
                datasets: [
                    {
                        data: [10, 20, 15, 30, 25, 50, 30, 25, 28, 32],
                        borderColor: "#2563eb",
                        backgroundColor: "transparent",
                        borderWidth: 2,
                        tension: 0.4,
                        pointRadius: 0,
                    },
                ],
            },
            options: {
                responsive: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { display: false },
                    y: { display: false },
                },
            },
        });
        // Pork Toppings mini chart
        const porkCtx = document
            .getElementById("porkToppingsChart")
            .getContext("2d");
        new Chart(porkCtx, {
            type: "line",
            data: {
                labels: Array.from({ length: 10 }, (_, i) => i + 1),
                datasets: [
                    {
                        data: [5, 10, 18, 25, 40, 35, 30, 28, 32, 36],
                        borderColor: "#22c55e",
                        backgroundColor: "transparent",
                        borderWidth: 2,
                        tension: 0.4,
                        pointRadius: 0,
                    },
                ],
            },
            options: {
                responsive: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { display: false },
                    y: { display: false },
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
