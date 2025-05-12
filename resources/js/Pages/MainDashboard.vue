<template>
    <Head title="Dashboard" />
    <div>
        <Sidebar class="fixed top-0 left-0 h-full w-64" />
        <div class="ml-64 flex flex-col min-h-screen">
            <div class="flex justify-between items-center p-6">
                <ProgresstrackerHeader />
                <button
                    class="bg-[#E64444] text-white text-base rounded-md hover:bg-[#992e2e] transition duration-200 min-w-[200px] p-2"
                    @click="importExcel"
                >
                    Import Excel File
                </button>
            </div>
            <div class="flex-1 p-6">
                <SalesReportChart />
            </div>
        </div>
    </div>
</template>
<script>
import ProgresstrackerHeader from "@/Components/Headers/progresstracker-header.vue";
import Sidebar from "@/Components/side-bar.vue";
import SalesReportChart from "@/Components/TablesandCharts/sales-report-chart.vue";
import { Head } from "@inertiajs/vue3";
export default {
    name: "OwnerDashboard",
    components: {
        ProgresstrackerHeader,
        Sidebar,
        SalesReportChart,
        Head,
    },
};
</script>

<style scoped>
body,
.dashboard-container {
    font-family: "Inter", sans-serif;
}
</style>
