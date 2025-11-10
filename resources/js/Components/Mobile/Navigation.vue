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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="text-xs font-medium">Home</span>
            </Link>
            <Link
                href="/"
                class="flex flex-col items-center gap-1 text-gray-600 hover:text-[#536b7b] transition-colors duration-200 flex-1"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6H19m-6 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                </svg>

                <span class="text-xs font-medium">Shop</span>
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
                href="/vendor/settings/get"
                class="flex flex-col items-center gap-1 text-gray-600 hover:text-[#536b7b] transition-colors duration-200 flex-1"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v6h6M20 20v-6h-6M4 10a8 8 0 0114.9-2M20 14a8 8 0 01-14.9 2" />
                </svg>

                <span class="text-xs font-medium">Update</span>
            </Link>

            <div
                    @click="toggleMenu"
                class="flex flex-col items-center gap-1 text-gray-600 hover:text-[#536b7b] transition-colors duration-200 flex-1"
                v-if="$page.props.auth.user.role === 'vendor'"
            >
                <DrawUpMenu :menuOpen="menuOpen"/>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>

                <span class="text-xs font-medium">More</span>
            </div>

        </div>
    </div>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
import AddEditJob from "@/Components/AddEditJob.vue";
import {ref} from 'vue'
import AddEditProduct from "@/Components/Vendor/AddEditProduct.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DrawUpMenu from "@/Components/Mobile/DrawUpMenu.vue";

let showAddRepairModal = ref(false)
let showAddProductModal = ref(false)
let productToEdit = ref(false)

const menuOpen = ref(false)
const openShowAddRepairModal = () => {
    showAddRepairModal.value = true
};


const toggleMenu = () => {
    menuOpen.value = !menuOpen.value
}

const openShowAddProductModal = () => {
    showAddProductModal.value = !showAddProductModal.value
};
</script>

<style scoped>

</style>
