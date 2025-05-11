<template>
    <div class="sidebar-container">
        <h1>Dar's BBQ</h1>
        <div class="profile-section">
            <div
                class="relative w-36 h-36 mx-auto cursor-pointer group"
                @click="triggerFileInput"
            >
                <img
                    class="w-full h-full rounded-[30px] object-cover"
                    :src="
                        userAvatar ||
                        'https://i.pinimg.com/736x/a8/45/2b/a8452b369156bec21cf5a665ac5458a4.jpg'
                    "
                    alt="User Avatar"
                />
                <div
                    class="absolute inset-0 bg-black/50 rounded-[30px] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                >
                    <span class="text-white w-6 h-6">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>
                    </span>
                </div>
                <input
                    type="file"
                    ref="fileInput"
                    class="hidden"
                    accept="image/*"
                    @change="handleFileUpload"
                />
            </div>
            <p class="profile-name">Winter</p>
        </div>

        <nav class="nav-links">
            <a href="#" class="home">Home</a>

            <a href="#" class="nav-link" @click.prevent="goToDashboard">
                <span class="icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 10h4V3H3v7zm0 11h4v-6H3v6zm7 0h4v-4h-4v4zm7 0h4V10h-4v11z"
                        />
                    </svg>
                </span>
                Dashboard
            </a>

            <a href="#" class="nav-link" @click.prevent="goToInventory">
                <span class="icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0H4"
                        />
                    </svg>
                </span>
                Inventory
            </a>

            <a href="#" class="nav-link" @click.prevent="goToHistory">
                <span class="icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                </span>
                History
            </a>

            <a href="#" class="nav-link" @click.prevent="goToEmployees">
                <span class="icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 20h5v-2a4 4 0 00-5-4m-6 6v-2a4 4 0 015-4m-6 6H6v-2a4 4 0 015-4m-6 6a4 4 0 01-4-4v-2a4 4 0 014-4m6 6a4 4 0 004-4v-2a4 4 0 00-4-4m0 0a4 4 0 00-4 4v2a4 4 0 004 4z"
                        />
                    </svg>
                </span>
                Employees
            </a>
        </nav>

        <button class="logout-button" @click="handleLogout">
            <span class="icon">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"
                    />
                </svg>
            </span>
            Logout
        </button>
    </div>
</template>

<script>
export default {
    name: "Sidebar",
    data() {
        return {
            userAvatar: null,
        };
    },
    methods: {
        handleLogout() {
            this.$router.push({ name: "Login" });
        },
        goToInventory() {
            this.$router.push({ name: "Inventory" });
        },
        goToHistory() {
            this.$router.push({ name: "History" });
        },
        goToDashboard() {
            this.$router.push({ name: "Dashboard" });
        },
        goToEmployees() {
            this.$router.push({ name: "Employees" });
        },
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                // Create a preview URL
                this.userAvatar = URL.createObjectURL(file);
                // Here you would typically upload the file to your server
                // and update the userAvatar with the server response URL
            }
        },
    },
};
</script>

<style scoped>
.sidebar-container {
    width: 250px;
    height: 100vh;
    background-color: #ffffff;
    display: flex;
    flex-direction: column;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 40;
}

h1 {
    font-family: "Inter", sans-serif;
    font-size: 24px;
    color: #732222;
    margin-bottom: 20px;
    text-align: center;
}

.profile-section {
    text-align: center;
    margin-bottom: 30px;
    padding: 10px;
    border-radius: 8px;
    width: 100%;
}

.profile-name {
    font-size: 18px;
    font-weight: bold;
    color: #232d42;
    margin: 5px 0;
}

.profile-role {
    font-size: 14px;
    color: #8a92a6;
}

.home {
    color: #8a92a6;
    display: block;
    text-align: left;
    width: 100%;
    margin-bottom: 5px;
}

.nav-links {
    background-color: white;
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 25px;
    margin-bottom: auto;
}

.nav-link {
    width: 100%;
    padding: 10px;
    background-color: #e64444;
    border-radius: 5px;
    color: white;
    display: flex;
    align-items: center;
    transition: background-color 0.3s;
}

.nav-link.active {
    background-color: #732222;
}

.nav-link:hover {
    background-color: #992e2e;
}

.icon {
    margin-right: 10px;
    width: 20px;
    height: 20px;
    display: inline-block;
}

.logout-button {
    width: 100%;
    padding: 10px;
    background-color: #e64444;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    transition: background-color 0.3s ease;
    margin-top: 1.5rem;
}

.logout-button:hover {
    background-color: #992e2e;
}

@media (max-width: 768px) {
    .sidebar-container {
        width: 200px;
        padding: 15px;
    }

    h1 {
        font-size: 20px;
    }

    .nav-link {
        font-size: 14px;
    }

    .logout-button {
        font-size: 14px;
    }
}
</style>
