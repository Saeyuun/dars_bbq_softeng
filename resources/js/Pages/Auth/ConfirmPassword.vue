<script setup>
import InputError from "@/Components/authComponents/InputError.vue";
import InputLabel from "@/Components/authComponents/InputLabel.vue";
import PrimaryButton from "@/Components/authComponents/PrimaryButton.vue";
import TextInput from "@/Components/authComponents/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";

import logo from "@/Assets/image-1.png";
import bgImage from "@/Assets/Image2.png";

const form = useForm({
    password: "",
});

const submit = () => {
    form.post(route("password.confirm"), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <div class="flex min-h-screen">
        <div
            class="w-full md:w-1/2 flex flex-col justify-center items-center bg-white px-8 py-6"
        >
            <div class="absolute top-4 left-4 flex items-center">
                <img :src="logo" alt="Logo" class="h-12 w-12 object-contain" />
            </div>

            <div class="w-full max-w-md mt-16 mb-2">
                <h1 class="text-3xl font-semibold text-gray-800 mb-2">
                    Dar’s BBQ
                </h1>
                <h2 class="text-2xl font-bold text-black text-center mb-6">
                    Confirm Password
                </h2>
                <div class="mb-4 text-sm text-gray-600 text-center">
                    This is a secure area of the application. Please confirm
                    your password before continuing.
                </div>
                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <InputLabel
                            for="password"
                            value="Password"
                            class="text-base text-gray-700"
                        />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full border-2 border-[#7B2E2E] rounded-md focus:border-[#7B2E2E] focus:ring-0"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                            autofocus
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.password"
                        />
                    </div>
                    <div class="flex justify-center mt-4">
                        <PrimaryButton
                            class="w-full bg-[#7B2E2E] hover:bg-[#5a1e1e] text-white py-2 rounded"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Confirm
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>

        <div class="hidden md:block md:w-1/2 h-screen relative">
            <div class="absolute inset-0 bg-black bg-opacity-20 z-10"></div>
            <img :src="bgImage" alt="BBQ" class="w-full h-full object-cover" />
        </div>
    </div>
</template>

<style scoped></style>
