<script setup>
import {Link} from "@inertiajs/vue3";
import AuthNavBar from "@/Components/AuthNavBar.vue";
import Navigation from "@/Components/Mobile/Navigation.vue";
</script>

<template>
    <div class="min-h-screen bg-primary relative">
        <AuthNavBar class="fixed min-h-screen z-50" />
        <!-- Navbar -->
        <nav class="sticky top-0 flex justify-between items-center px-6 py-4 shadow-md z-40
            bg-secondary text-primary md:bg-primary md:text-secondary">

            <div class="font-medium text-base md:font-bold md:text-lg md:ml-64 truncate">
                {{ $page.props.auth.user.name }}
            </div>

            <div>
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="bg-primary text-secondary md:bg-secondary md:text-primary px-4 py-2 rounded hover:bg-primary hover:text-secondary transition-colors duration-300"
                >
                    Logout
                </Link>
            </div>
        </nav>

        <main class="p-6">
            <slot />
        </main>

    </div>
        <Navigation />
</template>

<style>

</style>
