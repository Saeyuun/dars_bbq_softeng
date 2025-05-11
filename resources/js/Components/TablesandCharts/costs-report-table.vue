<template>
    <table class="min-w-full text-sm text-gray-700">
        <thead class="bg-gray-100 text-xs uppercase text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Cost ID</th>
                <th class="px-4 py-3 text-left">Total Price</th>
                <th class="px-4 py-3 text-left">Created At</th>
                <th class="px-4 py-3 text-left">Created By</th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="row in rows"
                :key="row.id"
                class="border-b hover:bg-gray-50"
            >
                <td class="px-4 py-3">{{ row.id }}</td>
                <td class="px-4 py-3">{{ row.price }}</td>
                <td class="px-4 py-3">{{ row.createdAt }}</td>
                <td class="px-4 py-3">{{ row.createdBy }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: "CostsReportTable",
    data() {
        return {
            rows: [
                // {
                //     id: 751,
                //     price: 1071,
                //     createdAt: "2024-12-15",
                //     createdBy: "Karina",
                // },
                // {
                //     id: 750,
                //     price: 500,
                //     createdAt: "2024-12-12",
                //     createdBy: "Karina",
                // },
                // {
                //     id: 749,
                //     price: 851,
                //     createdAt: "2024-12-10",
                //     createdBy: "Karina",
                // },
                // {
                //     id: 748,
                //     price: 254,
                //     createdAt: "2024-12-05",
                //     createdBy: "Winter",
                // },
                // {
                //     id: 747,
                //     price: 971,
                //     createdAt: "2024-12-02",
                //     createdBy: "Gizele",
                // },
                // {
                //     id: 746,
                //     price: 487,
                //     createdAt: "2024-11-31",
                //     createdBy: "Winter",
                // },
                // {
                //     id: 745,
                //     price: 863,
                //     createdAt: "2024-11-28",
                //     createdBy: "Ningning",
                // },
            ],
        };
    },
};
</script>
