<template>
    <table class="min-w-full text-sm text-gray-700">
        <thead class="bg-gray-100 text-xs uppercase text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Order ID</th>
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
    name: "SalesReportTable",
    data() {
        return {
            rows: [
                // {
                //     id: 1299,
                //     price: 200,
                //     createdAt: "2024-12-19",
                //     createdBy: "Karina",
                // },
                // {
                //     id: 1298,
                //     price: 300,
                //     createdAt: "2024-12-19",
                //     createdBy: "Karina",
                // },
                // {
                //     id: 1297,
                //     price: 400,
                //     createdAt: "2024-12-19",
                //     createdBy: "Karina",
                // },
                // {
                //     id: 1296,
                //     price: 150,
                //     createdAt: "2024-12-19",
                //     createdBy: "Karina",
                // },
                // {
                //     id: 1295,
                //     price: 500,
                //     createdAt: "2024-12-19",
                //     createdBy: "Karina",
                // },
                // {
                //     id: 1294,
                //     price: 50,
                //     createdAt: "2024-12-19",
                //     createdBy: "Karina",
                // },
                // {
                //     id: 1293,
                //     price: 150,
                //     createdAt: "2024-12-19",
                //     createdBy: "Karina",
                // },
            ],
        };
    },
};
</script>
