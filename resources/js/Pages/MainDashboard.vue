<template>
    <div class="dashboard-container p-5">
        <div class="flex justify-between items-center mb-10">
            <ProgresstrackerHeader />
            <button
                class="bg-[#E64444] text-white text-base rounded-md hover:bg-[#992e2e] transition duration-200 min-w-[200px] ml-115 mb-6"
                @click="importExcel"
            >
                Import Excel File
            </button>
        </div>
        <SalesReportChart />
        <SideBarOwner />
    </div>
</template>

<script>
import ProgresstrackerHeader from "@/Components/Headers/progresstracker-header.vue";
import SideBarOwner from "@/Components/side-bar-owner.vue";
import SalesReportChart from "@/Components/TablesandCharts/sales-report-chart.vue";

export default {
    name: "OwnerDashboard",
    components: {
        ProgresstrackerHeader,
        SideBarOwner,
        SalesReportChart,
    },
};
</script>

<style scoped>
.dashboard-container {
    font-family: "Inter", sans-serif;
}
</style>
