<template>
  <HistoryHeader />
  <SideBarEmployee />
  <DateFilter @date-change="updateSelectedDate" />

  <div class="p-5 flex">
    <!-- Table Section -->
    <div
      class="flex-grow relative overflow-x-auto shadow-md sm:rounded-lg bg-white"
    >
      <table class="w-full text-sm text-left text-gray-500">
        <thead
          class="text-xs text-gray-700 uppercase bg-gray-100 border-b border-gray-200"
        >
          <tr>
            <th scope="col" class="px-6 py-3">ID</th>
            <th scope="col" class="px-6 py-3">Item</th>
            <th scope="col" class="px-6 py-3">Status</th>
            <th scope="col" class="px-6 py-3">New Quantity</th>
            <th scope="col" class="px-6 py-3">Date Added</th>
          </tr>
        </thead>
        <tbody>
          <template v-if="filteredItems.length > 0">
            <template v-for="item in filteredItems" :key="item.id">
              <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                <th
                  scope="row"
                  class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                >
                  {{ item.id }}
                </th>
                <td class="px-6 py-4">{{ item.name }}</td>
                <td class="px-6 py-4">{{ item.status }}</td>
                <td class="px-6 py-4">{{ item.newQuantity }}</td>
                <td class="px-6 py-4">{{ item.dateAdded }}</td>
              </tr>
            </template>
          </template>
          <tr v-else>
            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
              No items found for the selected date.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Cards Section -->
    <div class="ml-5 flex flex-col space-y-4">
      <!-- Low on Stock Card -->
      <div class="bg-white p-4 rounded-lg shadow-md">
        <h3 class="ext-xl font-semibold mt-2">Low on Stock</h3>
        <p class="text-sm text-gray-500">On December 19, 2024</p>
        <p class="text-xl font-semibold mt-2">Garlic</p>
        <p class="text-sm text-gray-500">2 Kg</p>
        <button
          class="w-48 bg-[#5BD069] text-center justify-start text-white text-base font-normal leading-7"
        >
          Update
        </button>
      </div>

      <!-- No Stock Card -->
      <div class="bg-white p-4 rounded-lg shadow-md">
        <h3 class="ext-xl font-semibold mt-2 mb-2">No Stock</h3>
        <p class="text-sm text-gray-500">On December 19, 2024</p>
        <p class="text-xl font-semibold mt-2 mb-2">Eggs</p>
        <button
          class="w-48 bg-[#5BD069] text-center justify-start text-white text-base font-normal leading-7"
        >
          Update
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import HistoryHeader from "@/components/Headers/history-header.vue";
import SideBarEmployee from "@/components/side-bar-employee.vue";
import DateFilter from "@/components/date-filter.vue";

export default {
  name: "History",
  components: {
    HistoryHeader,
    SideBarEmployee,
    DateFilter,
  },
  data() {
    return {
      selectedDate: null, // Store the selected date
      items: [
        {
          id: 127,
          name: "Chicken Wings",
          status: "Created",
          newQuantity: 10,
          dateAdded: "2023-04-01",
          description: "Fresh chicken wings ready for grilling.",
        },
        {
          id: 126,
          name: "Pork Ribs",
          status: "Updated",
          newQuantity: 15,
          dateAdded: "2023-03-28",
          description: "Tender pork ribs in stock.",
        },
        {
          id: 125,
          name: "Beef Brisket",
          status: "Deleted",
          newQuantity: 0,
          dateAdded: "2023-03-15",
          description: "Beef brisket is currently out of stock.",
        },
        {
          id: 124,
          name: "Sausages",
          status: "Created",
          newQuantity: 8,
          dateAdded: "2023-04-05",
          description: "Smoked sausages available.",
        },
        {
          id: 123,
          name: "Corn on the Cob",
          status: "Created",
          newQuantity: 5,
          dateAdded: "2023-04-10",
          description: "Fresh corn on the cob for sides.",
        },
        {
          id: 122,
          name: "BBQ Sauce",
          status: "Deleted",
          newQuantity: 0,
          dateAdded: "2023-03-20",
          description: "BBQ sauce is currently out of stock.",
        },
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