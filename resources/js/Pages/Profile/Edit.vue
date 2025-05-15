<script setup>
import { ref } from "vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import logo from "@/assets/image-1.png";
import Notification from "@/Components/Notification.vue";

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    user: {
        type: Object,
        required: false,
    },
});

const previewUrl = ref(null);
const showNotification = ref(false);
const notificationMessage = ref('');
const notificationType = ref('success');

const pictureForm = useForm({
    profile_picture: null,
});

function onFileChange(e) {
    const file = e.target.files[0];
    pictureForm.profile_picture = file;
    if (file) {
        previewUrl.value = URL.createObjectURL(file);
    } else {
        previewUrl.value = null;
    }
}

function submitPicture() {
    pictureForm.post(route("profile.picture.update"), {
        preserveScroll: true,
        onSuccess: () => {
            previewUrl.value = null;
            pictureForm.reset("profile_picture");
            notificationMessage.value = 'Profile picture updated successfully';
            notificationType.value = 'success';
            showNotification.value = true;
            setTimeout(() => {
                showNotification.value = false;
            }, 3000);
        },
        onError: () => {
            notificationMessage.value = 'Failed to update profile picture';
            notificationType.value = 'error';
            showNotification.value = true;
            setTimeout(() => {
                showNotification.value = false;
            }, 3000);
        }
    });
}
</script>

<template>
    <Head title="Profile" />
    <div class="min-h-screen bg-white py-12">
        <div class="max-w-2xl mx-auto">
            <Link
                :href="route('dashboard')"
                class="inline-flex items-center text-gray-500 hover:text-[#E64444] text-sm font-medium mb-4 transition"
            >
                <span class="mr-2">&#8592;</span> Back to Dashboard
            </Link>
            <div class="flex items-center gap-4 mb-8">
                <img :src="logo" alt="Logo" class="h-12 w-12 object-contain" />
                <h2 class="text-2xl font-bold text-gray-800">Profile</h2>
            </div>
            <div class="space-y-8 p-6 bg-white shadow-lg rounded-2xl">
                <!-- Profile Picture Editor -->
                <div
                    class="flex flex-col items-center -mt-16 mb-4 relative z-10"
                >
                    <label
                        class="cursor-pointer group flex flex-col items-center"
                    >
                        <img
                            :src="
                                previewUrl ||
                                (user && user.employee?.avatar_url) ||
                                '/images/default-avatar.png'
                            "
                            alt="Profile Picture"
                            class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg bg-white group-hover:opacity-80 transition"
                        />
                        <input
                            type="file"
                            accept="image/*"
                            @change="onFileChange"
                            class="hidden"
                        />
                    </label>
                    <button
                        @click="submitPicture"
                        :disabled="!pictureForm.profile_picture"
                        class="mt-2 text-xs bg-[#E64444] hover:bg-red-600 text-white px-3 py-1 rounded font-semibold disabled:opacity-50"
                    >
                        Save
                    </button>
                </div>
                <div class="bg-white p-6 shadow rounded-xl">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>
                <div class="bg-white p-6 shadow rounded-xl">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>
                <div class="bg-white p-6 shadow rounded-xl">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </div>
    <Notification
        :show="showNotification"
        :message="notificationMessage"
        :type="notificationType"
        @close="showNotification = false"
    />
</template>
