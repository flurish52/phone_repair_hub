<template>
    <AuthenticatedLayout>
        <!-- Fixed Tabs at top -->
        <div class="fixed top-16 left-0  md:pl-64 right-0 z-40 bg-primary shadow-md">
            <Tabs
                :tabs="['Vendors', 'Accessories']"
                :activeTab="currentTab"
                @update:activeTab="currentTab = $event"
            />
        </div>
        <div class="min-h-screen bg-primary flex flex-col items-center w-full">
            <component :is="currentComponent" :vendor="vendor"  :items="currentTab === 'Vendors' ? vendors : products"
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
    vendors: Array,
    vendor: Object,
    products: Array,

    activeTab: String,
})

const currentTab = ref(props.activeTab ?? 'Accessories'
);

// Example data
const selectedProduct = ref(props.selectedProduct?? null);


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
