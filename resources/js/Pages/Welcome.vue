<template>
        <!-- Fixed Tabs at top -->
    <GuestLayout>
        <GuestNavBar />
    <div class="fixed top-12 my-2 left-0  md:pl-64 right-0 z-40 bg-primary shadow-md">
        <Tabs
                :tabs="['Products', 'Vendors' ]"
                :activeTab="currentTab"
                :vendor_brands="vendor_brands"
                :vendor_cats="vendor_cats"
        />
    </div>
    <div class="mt-24">
        <HeroSlider />
    </div>
    <div class="min-h-screen bg-primary px-6 flex flex-col mt- items-center w-full">
        <component :is="currentComponent" :vendor="vendor" :items="currentTab === 'Vendors' ? vendors : products"
        />
    </div>
<footer class=" bg-secondary text-primary py-3">
<div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
    <p class="text-sm">&copy; {{ new Date().getFullYear() }} Phixobel</p>
    <nav class="flex gap-4 mt-3 md:mt-0">
        <a href="#" class="text-primary hover:underline">Privacy</a>
        <a href="#" class="text-primary hover:underline">Terms</a>
        <a href="#" class="text-primary hover:underline">Contact</a>
    </nav>
</div>
</footer>
    </GuestLayout>
</template>

<script setup>
import Tabs from '@/Components/Partials/Tab.vue'
import {ref, computed} from 'vue';

import VendorList from '@/Components/Accessories/VendorList.vue';
import ProductList from '@/Components/Accessories/ProductList.vue';
import GuestNavBar from "@/Components/Partials/GuestNavBar.vue";
import HeroSlider from "@/Components/Home/HeroSlider.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";

const props = defineProps({
    selectedProduct: Object,
    vendors: Array,
    vendor: Object,
    products: Array,
    activeTab: String,
    vendor_brands: Array,
    vendor_cats: Array,
})

const currentTab = ref(props.activeTab ?? 'products'
);

const tabComponents = {
    Vendors: VendorList,
    Accessories: ProductList,
};

const currentComponent = computed(() => tabComponents[currentTab.value] || ProductList);
</script>
