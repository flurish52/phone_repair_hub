<template>
    <aside class="hidden md:flex flex-col w-56 bg-secondary text-primary p-6 space-y-6">
        <h2 class="text-2xl font-bold mb-8">Dashboard</h2>
        <nav class="flex flex-col space-y-4">
            <Link
                href="/dashboard"
                class="text-left py-2 px-4 rounded hover:bg-primary hover:text-secondary transition-colors duration-300 flex items-center space-x-2">
                <span>🏠</span>
                <span>Home</span>
            </Link>

            <Link
                href="/prices"
                class="text-left py-2 px-4 rounded hover:bg-primary hover:text-secondary transition-colors duration-300 flex items-center space-x-2">
                <span>💰</span>
                <span>Prices</span>
            </Link>
        </nav>
    </aside>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";

</script>

<style scoped>

</style>
