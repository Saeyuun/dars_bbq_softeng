<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/authComponents/InputError.vue";
import InputLabel from "@/Components/authComponents/InputLabel.vue";
import PrimaryButton from "@/Components/authComponents/PrimaryButton.vue";
import TextInput from "@/Components/authComponents/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

import logo from "@/Assets/image-1.png";
import bgImage from "@/Assets/Image2.png";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Register" />
    <div class="flex flex-col md:flex-row min-h-screen">
        <div class="hidden md:block md:w-1/2 h-screen relative">
            <div class="absolute inset-0 bg-black bg-opacity-20 z-10"></div>
            <img :src="bgImage" alt="BBQ" class="w-full h-full object-cover" />
        </div>

        <div
            class="w-full md:w-1/2 flex flex-col justify-center items-center bg-white px-4 sm:px-8 py-8 relative"
        >
            <div class="absolute top-4 right-4 flex items-center">
                <img :src="logo" alt="Logo" class="h-12 w-12 object-contain" />
            </div>

            <div class="w-full max-w-md mt-10 mb-2">
                <h2 class="text-2xl font-bold text-[#7B2E2E] text-center mb-6">
                    Register
                </h2>
                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <InputLabel
                            for="name"
                            value="Name"
                            class="text-base text-gray-700"
                        />
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full border-2 border-[#7B2E2E] rounded-md focus:border-[#7B2E2E] focus:ring-0"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div>
                        <InputLabel
                            for="email"
                            value="Email"
                            class="text-base text-gray-700"
                        />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full border-2 border-[#7B2E2E] rounded-md focus:border-[#7B2E2E] focus:ring-0"
                            v-model="form.email"
                            required
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
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
                            autocomplete="new-password"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.password"
                        />
                    </div>
                    <div>
                        <InputLabel
                            for="password_confirmation"
                            value="Confirm Password"
                            class="text-base text-gray-700"
                        />
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full border-2 border-[#7B2E2E] rounded-md focus:border-[#7B2E2E] focus:ring-0"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.password_confirmation"
                        />
                    </div>
                    <div
                        class="flex flex-col sm:flex-row items-center justify-end mt-4 gap-2 sm:gap-0"
                    >
                        <Link
                            :href="route('login')"
                            class="rounded-md text-sm text-[#7B2E2E] underline hover:text-[#5a1e1e] focus:outline-none focus:ring-2 focus:ring-[#7B2E2E] focus:ring-offset-2"
                        >
                            Already registered?
                        </Link>
                        <PrimaryButton
                            class="sm:ms-4 w-full sm:w-40 bg-[#7B2E2E] hover:bg-[#5a1e1e] text-white py-2 rounded font-semibold text-base shadow-md mt-2 transition justify-center"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Register
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
