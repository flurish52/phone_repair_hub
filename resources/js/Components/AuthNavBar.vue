<template>
    <aside class="hidden md:flex flex-col w-56 bg-secondary text-primary p-6 space-y-6">
        <h2 class="text-2xl font-bold mb-8">Dashboard</h2>
        <nav class="flex flex-col space-y-4">
            <Link
                v-for="item in links"
                :key="item.href"
                :href="item.href"
                class="text-left py-2 px-4 rounded hover:bg-primary hover:text-secondary transition-colors duration-300 flex items-center space-x-2">
                <span>{{ item.icon }}</span>
                <span>{{ item.label }}</span>
            </Link>
        </nav>
    </aside>
</template>

<script setup>
import {Link} from "@inertiajs/vue3"

const links = [
    {label: 'Home', href: '/dashboard', icon: '🏠'},
    {label: 'Products', href: '/', icon: '🛒'},
    {label: 'Categories', href: '/vendor/categories/get', icon: '🗂️'},
    {label: 'Brands', href: '/vendor/brands/get', icon: '🏷️'},
    {label: 'Settings', href: '/vendor/settings/get', icon: '⚙️'},
]
</script>
