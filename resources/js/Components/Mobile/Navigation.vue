<template>
    <AddEditJob
        :show="showAddRepairModal"
        @close="showAddRepairModal = false"
    />

    <AddEditProduct
        :show="showAddProductModal"
        :product="productToEdit"
        @close="showAddProductModal = false"
    />

    <div class="fixed bottom-0 left-0 right-0 md:hidden bg-white border-t border-gray-200 shadow-2xl z-50">
        <div class="flex justify-around items-center px-4 py-3 max-w-lg mx-auto">
            <Link
                href="/dashboard"
                class="flex flex-col items-center gap-1 text-gray-600 hover:text-[#536b7b] transition-colors duration-200 flex-1"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="text-xs font-medium">Home</span>
            </Link>

            <button
                v-if="$page.props.auth.user.role.toLowerCase() === 'engineer'"
                @click="openShowAddRepairModal"
                class="flex items-center justify-center -mt-8 w-14 h-14 bg-gradient-to-br from-[#536b7b] to-[#3a4d5a] text-white rounded-full shadow-xl hover:shadow-2xl transition-all duration-200 hover:scale-105 active:scale-95"
            >
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
            </button>
            <Link
                v-else-if="$page.props.auth.user.role.toLowerCase() === 'vendor'"
                href="/product/create"
                class="flex items-center justify-center -mt-8 w-14 h-14 bg-gradient-to-br from-[#536b7b] to-[#3a4d5a] text-white rounded-full shadow-xl hover:shadow-2xl transition-all duration-200 hover:scale-105 active:scale-95"
            >
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
            </Link>
            <button
                v-else
                @click="openShowAddRepairModal"
                class="flex items-center justify-center -mt-8 w-14 h-14 bg-gradient-to-br from-[#536b7b] to-[#3a4d5a] text-white rounded-full shadow-xl hover:shadow-2xl transition-all duration-200 hover:scale-105 active:scale-95"
            >
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
            </button>

            <Link
                href="/accessories"
                class="flex flex-col items-center gap-1 text-gray-600 hover:text-[#536b7b] transition-colors duration-200 flex-1"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-xs font-medium">Accessories</span>
            </Link>
        </div>
    </div>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
import AddEditJob from "@/Components/AddEditJob.vue";
import {ref} from 'vue'
import AddEditProduct from "@/Components/Vendor/AddEditProduct.vue";
let showAddRepairModal = ref(false)
let showAddProductModal = ref(false)
let productToEdit = ref(false)

const openShowAddRepairModal =()=>{
    showAddRepairModal.value  = true
};

const openShowAddProductModal =()=>{
        showAddProductModal.value = !showAddProductModal.value
};
</script>

<style scoped>

</style>
