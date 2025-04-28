<template>
  <div class="p-4">
    <div class="mt-2">
      <div
        class="flex items-center rounded-md bg-[#FFE3E3] pl-3 pr-3 py-2 outline outline-1 outline-[#E64444] focus-within:outline-2 focus-within:-outline-offset-2"
      >
        <!-- Calendar Icon -->
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="mr-2 h-5 w-5 text-[#E64444]"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M8 7V3m8 4V3m-9 8h10m-12 8h14a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"
          />
        </svg>

        <!-- Date Input (styled like a button) -->
        <input
          type="date"
          name="filter-date"
          id="filter-date"
          v-model="selectedDate"
          @change="emitDate"
          class="flex-grow cursor-pointer text-[#1f1f1f] bg-transparent text-base placeholder-gray-500 focus:outline-none appearance-none"
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DateFilter",
  props: {
    modelValue: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      selectedDate: this.modelValue,
    };
  },
  watch: {
    modelValue(newVal) {
      this.selectedDate = newVal;
    },
  },
  methods: {
    emitDate() {
      this.$emit("update:modelValue", this.selectedDate);
      
    },
  },
};
</script>
