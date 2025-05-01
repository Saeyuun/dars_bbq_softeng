<template>
    <div class="p-4">
        <div class="mt-2">
            <div
                class="flex items-center rounded-md bg-white px-3 py-2 outline outline-1 outline-[#E64444] focus-within:outline-2 focus-within:-outline-offset-2"
            >
                <input
                    type="date"
                    name="filter-date"
                    id="filter-date"
                    v-model="selectedDate"
                    @change="emitDate"
                    class="flex-grow cursor-pointer text-[gray] bg-transparent text-base placeholder-gray-400 focus:outline-none appearance-none border-none"
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
