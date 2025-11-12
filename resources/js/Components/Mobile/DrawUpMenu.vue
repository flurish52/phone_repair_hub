<template>
    <div class="fixed bottom-16 right-4">

        <!-- Pop-up menu -->
        <div v-if="menuOpen" class="mt-6 w-32 bg-white shadow-lg rounded-lg overflow-hidden">
            <a v-for="item in menuItems" :key="item.name" :href="item.link" class="flex items-center p-3 hover:bg-gray-100">
                <span class="mr-2" v-html="item.icon"></span>
                <span>{{ item.name }}</span>
            </a>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
defineProps({
    menuOpen: Boolean,
})

const menuItems = [
    { name: 'Brands', link: '/vendor/brands/get', icon: '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9v9a3 3 0 01-3 3H6a3 3 0 01-3-3v-9z"/></svg>' },
    // { name: 'Categories', link: '/vendor/categories/get', icon: '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z"/></svg>' },
]
</script>

<style scoped>
</style>
