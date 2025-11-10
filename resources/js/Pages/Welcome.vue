<template>
        <!-- Fixed Tabs at top -->
    <GuestLayout>
        <GuestNavBar />
    <div class="fixed top-12 my-2 left-0  md:pl-64 right-0 z-40 bg-primary shadow-md">
        <Tabs
                :tabs="['Products', 'Vendors' ]"
                :activeTab="currentTab"
                :vendors_list="vendors_list.data"
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
import Navigation from "@/Components/Mobile/Navigation.vue";

const props = defineProps({
    selectedProduct: Object,
    vendors: Array,
    vendor: Object,
    products: Array,
    activeTab: String,
    vendors_list: Array,
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
