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
      <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
      <input
      type="text"
      id="status"
      v-model="form.status"
      class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
      />
    </div>
    <div class="mb-4">
      <label for="measurement" class="block text-sm font-medium text-gray-700">Measurement</label>
      <select
      id="measurement"
      v-model="form.measurement"
      class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
      >
      <option value="kilogram">Kilogram</option>
      <option value="gram">Gram</option>
      <option value="liter">Liter</option>
      <option value="milliliter">Milliliter</option>
      <option value="pound">Pound</option>
      <option value="ounce">Ounce</option>
      </select>
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
      <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
      <textarea
        id="description"
        v-model="form.description"
        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#E64444]"
      ></textarea>
    </div>
    <button
      type="submit"
      class="w-full bg-[#E64444] text-white font-semibold py-2 rounded-md hover:bg-[#c33] focus:outline-none focus:ring-2 focus:ring-[#E64444]"
    >
      Add Item
    </button>
  </form>
</template>

<script>
export default {
  name: "AddItem",
  data() {
    return {
      form: {
        name: "",
        status: "",
        measurement: "",
        quantity: 0,
        description: "",
      },
    };
  },
  methods: {
    submitForm() {
      this.$emit("add-item", this.form);
    },
  },
};
</script>