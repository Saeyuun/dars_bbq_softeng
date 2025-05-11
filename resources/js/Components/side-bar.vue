<template>
    <div class="sidebar-container">
        <h1>Dar's BBQ</h1>
        <div class="profile-section">
            <Link
                :href="route('profile.edit')"
                class="block w-36 h-36 mx-auto group"
            >
                <img
                    class="w-full h-full rounded-[30px] object-cover"
                    src="https://www.svgrepo.com/show/384674/account-avatar-profile-user-11.svg"
                    alt="User Avatar"
                />
            </Link>
            <p class="profile-name">{{ $page.props.auth.user.name }}</p>
        </div>

        <nav class="nav-links">
            <Link :href="route('dashboard')" class="home">Home</Link>

            <Link :href="route('dashboard')" class="nav-link">
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
            </Link>

            <Link :href="route('inventory')" class="nav-link">
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
            </Link>

            <Link :href="route('history')" class="nav-link">
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
            </Link>

            <Link :href="route('employees')" class="nav-link">
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
            </Link>
        </nav>

        <Link
            :href="route('logout')"
            method="post"
            as="button"
            class="logout-button"
        >
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
        </Link>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
    name: "Sidebar",
    components: {
        Link,
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
    display: flex;
    align-items: center;
    gap: 10px;
    color: #8a92a6;
    text-decoration: none;
    padding: 10px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.nav-link:hover {
    background-color: #f8f9fa;
    color: #e64444;
}

.nav-link .icon {
    width: 20px;
    height: 20px;
}

.logout-button {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #8a92a6;
    background: none;
    border: none;
    padding: 10px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    text-align: left;
}

.logout-button:hover {
    background-color: #f8f9fa;
    color: #e64444;
}

.logout-button .icon {
    width: 20px;
    height: 20px;
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
