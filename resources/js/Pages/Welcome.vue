<template>
        <!-- Fixed Tabs at top -->
            <GuestNavBar />
        <div class="fixed top-12 my-2 left-0  md:pl-64 right-0 z-40 bg-primary shadow-md">
            <Tabs
                :tabs="['Accessories', 'Vendors' ]"
                :activeTab="currentTab"
            />
        </div>
    <div class="mt-24">
            <HeroSlider />
    </div>
        <div class="min-h-screen bg-primary px-6 flex flex-col mt- items-center w-full">
            <component :is="currentComponent" :vendor="vendor" :items="currentTab === 'Vendors' ? vendors : products"
            />
        </div>
</template>

<script setup>
import Tabs from '@/Components/Partials/Tab.vue'
import {ref, computed} from 'vue';

import VendorList from '@/Components/Accessories/VendorList.vue';
import ProductList from '@/Components/Accessories/ProductList.vue';
import GuestNavBar from "@/Components/Partials/GuestNavBar.vue";
import HeroSlider from "@/Components/Home/HeroSlider.vue";

const props = defineProps({
    selectedProduct: Object,
    vendors: Array,
    vendor: Object,
    products: Array,
    activeTab: String,
})

const currentTab = ref(props.activeTab ?? 'Accessories'
);

// Example data
const selectedProduct = ref(props.selectedProduct ?? null);


const clsoseViewProductModal = () => {
    selectedProduct.value = null
    window.history.replaceState(null, '', '/accessories')
}

const tabComponents = {
    Vendors: VendorList,
    Accessories: ProductList,
};

const currentComponent = computed(() => tabComponents[currentTab.value] || ProductList);
</script>
