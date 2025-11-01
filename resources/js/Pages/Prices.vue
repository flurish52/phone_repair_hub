<template>
    <AuthenticatedLayout>
        <ViewProduct
            v-if="selectedProduct"
            :product="selectedProduct"
            @close="clsoseViewProductModal"
        />
        <!-- Fixed Tabs at top -->
        <div class="fixed top-16 left-0  md:pl-64 right-0 z-40 bg-primary shadow-md">
            <Tabs
                :tabs="['Vendors', 'Accessories']"
                :activeTab="currentTab"
                @update:activeTab="currentTab = $event"
            />
        </div>
        <div class="min-h-screen bg-primary flex flex-col items-center w-full">
            <component :is="currentComponent" :items="currentTab === 'Vendors' ? vendors : products"
            />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Tabs from '@/Components/Partials/Tab.vue'
import {ref, computed} from 'vue';

import VendorList from '@/Components/Accessories/VendorList.vue';
import ProductList from '@/Components/Accessories/ProductList.vue';
import ViewProduct from "@/Components/Accessories/ViewProduct.vue";

const props = defineProps({
    selectedProduct: Object,
    activeTab: String,
})

const currentTab = ref(props.activeTab ?? 'Accessories'
);

// Example data
const products = ref([
    {
        id: 2,
        name: 'iPhone 11 Case',
        slug: '2',
        category: 'Accessories',
        brand: 'Oraimo',
        price: 2000,
        image_url: 'https://i.pinimg.com/736x/ac/df/7e/acdf7eb60e5d72b8120be562ddf474b0.jpg'
    },
    {
        id: 3,
        name: 'Samsung Charger',
        slug: '3',
        category: 'Accessories',
        brand: 'Samsung',
        price: 2500,
        image_url: 'https://i.pinimg.com/736x/ac/df/7e/acdf7eb60e5d72b8120be562ddf474b0.jpg'
    },
    {
        id: 4,
        name: 'iPhone 11 Case',
        slug: '4',
        category: 'Accessories',
        brand: 'Oraimo',
        price: 2000,
        image_url: 'https://i.pinimg.com/736x/ac/df/7e/acdf7eb60e5d72b8120be562ddf474b0.jpg'
    },
    {
        id: 6,
        name: 'Samsung Charger',
        slug: '6',
        category: 'Accessories',
        brand: 'Samsung',
        price: 2500,
        image_url: 'https://i.pinimg.com/736x/ac/df/7e/acdf7eb60e5d72b8120be562ddf474b0.jpg'
    },
]);
const selectedProduct = ref(props.selectedProduct?? null);


const vendors = ref([
    { id: 1, name: 'Tech World', slug:'Tech', address: '123 Main St, Lagos', productsCount: 5, image_url: 'https://i.pinimg.com/736x/ac/df/7e/acdf7eb60e5d72b8120be562ddf474b0.jpg' },
    { id: 2, name: 'Mobile Hub', slug:'Mobile', address: '45 Ajose St, Ikeja', productsCount: 3, image_url: 'https://i.pinimg.com/736x/ac/df/7e/acdf7eb60e5d72b8120be562ddf474b0.jpg' },
    { id: 3, name: 'Gadget Center', slug:'Gadget', address: '78 Marina Rd, Lagos vendor.address && vendor.address.length > 100 ? vendor.address.slice(0, 100) ', productsCount: 7, image_url: 'https://i.pinimg.com/736x/ac/df/7e/acdf7eb60e5d72b8120be562ddf474b0.jpg' },
    { id: 4, name: 'Apple Store', slug:'Apple', address: '12 Victoria Island, Lagos', productsCount: 4, image_url: 'https://i.pinimg.com/736x/ac/df/7e/acdf7eb60e5d72b8120be562ddf474b0.jpg' },
]);


const clsoseViewProductModal =()=>{
    selectedProduct.value = null
    window.history.replaceState(null, '', '/accessories')
}

const tabComponents = {
    Vendors: VendorList,
    Accessories: ProductList,
};

const currentComponent = computed(() => tabComponents[currentTab.value] || ProductList);
</script>
