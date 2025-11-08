<template>
    <div class="flex justify-between border-b border-gray-200 px-6 items-center relative">

        <!-- Left sidebar button (Categories) -->
        <button
            class="mr-4 p-2 rounded bg-primary md:hidden  text-secondary"
            @click="sidebarOpenCategories = true"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>

        </button>
        <button class="hidden md:block"
        >
        </button>

        <!-- Left Overlay -->
        <div
            v-show="sidebarOpenCategories"
            @click="sidebarOpenCategories = false"
            class="fixed inset-0 bg-black/10 z-40 md:hidden transition-opacity"
        ></div>

        <!-- Left Sidebar (Categories) -->
        <SideBar
            title="Categories"
            urlPrefix="categories"
            :items="vendor_cats"
            @close="sidebarOpenCategories = false"
            class="fixed top-0 left-0 md:left-8 h-full z-50 rounded-md shadow-md w-64 transform transition-transform duration-300 bg-white"
            :class="sidebarOpenCategories ? 'translate-x-0' : '-translate-x-full'"
        />

        <SearchComponent class=" "/>
        <Link
            v-for="(tab, index) in tabs"
            :key="index"
            :href="route('products.tab', { tab })"
            :class="[
                'px-4 py-2 font-medium text-sm md:text-base rounded-t-lg transition-colors duration-200',
                tab === activeTab
                    ? 'bg-secondary text-primary border-t border-x border-gray-200'
                    : 'bg-primary-light text-secondary-dark hover:bg-primary'
            ]"
        >
            {{ tab }}
        </Link>

        <!-- Right sidebar button (Brands) -->
        <button
            class=" p-2 rounded  text-secondary"
            @click="sidebarOpenBrands = true"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Right Overlay -->
        <div
            v-show="sidebarOpenBrands"
            @click="sidebarOpenBrands = false"
            class="fixed inset-0 bg-black/10 z-40 md:hidden transition-opacity"
        ></div>

        <!-- Right Sidebar (Brands) -->
        <SideBar
            title="Top brands"
            urlPrefix="brands"
            :items="vendor_brands"
            @close="sidebarOpenBrands = false"
            class="fixed  top-0 right-0 h-full z-50 rounded-md shadow-md w-64 bg-white transform transition-transform duration-300"
            :class="sidebarOpenBrands ? 'translate-x-0' : 'translate-x-full'"
        />

    </div>
</template>


<script setup>
import SideBar from "@/Components/Mobile/SideBar.vue";
import {ref} from 'vue';
import {Link} from "@inertiajs/vue3";
import SearchComponent from "@/Components/Partials/SearchComponent.vue";

const sidebarOpenCategories = ref(false)
const sidebarOpenBrands = ref(false)

defineProps({
    tabs: {type: Array, required: true},
    activeTab: {type: String, required: true},
    vendor_brands: Array,
    vendor_cats: Array,
})

defineEmits(['update:activeTab'])
</script>
