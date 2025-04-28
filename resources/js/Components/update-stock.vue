<template>
  <form @submit.prevent="submitForm">
    <div class="mb-4">
      <label for="name" class="block text-sm font-medium text-gray-700">Item Name</label>
      <input
        type="text"
        id="name"
        v-model="form.name"
        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
      />
    </div>
    <div class="mb-4">
      <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
      <input
        type="number"
        id="quantity"
        v-model="form.quantity"
        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
      />
    </div>
    <div class="mb-4">
      <label for="measurement" class="block text-sm font-medium text-gray-700">Measurement</label>
      <input
        type="number"
        id="measurement"
        v-model="form.measurement"
        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
      />
    </div>
    
    <button
      type="submit"
      class="w-full bg-[#E64444] text-white font-semibold py-2 rounded-md hover:bg-[#c33] focus:outline-none focus:ring-2 focus:ring-[#E64444]"
    >
      Update
    </button>
  </form>
</template>

<script>
export default {
  name: "Updates Stocks",
  data() {
    return {
      form: {
        name: "",
        quantity: 0,
        measurement: "",
      },
    };
  },
  methods: {
    submitForm() {
      this.$emit("update-stocks", this.form);
    },
  },
};
</script>