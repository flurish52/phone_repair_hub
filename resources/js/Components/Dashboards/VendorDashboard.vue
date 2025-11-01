<template>
    <div class="flex min-h-screen bg-primary">
        <!-- Modals -->
<!--        <ViewProduct-->
<!--            :show="showViewProductModal"-->
<!--            :product="productToView"-->
<!--            @close="showViewProductModal = false"-->
<!--        />-->
        <AddEditProduct
            :show="showAddProductModal"
            :product="productToEdit"
            @close="showAddProductModal = false"
        />

        <!-- Main content -->
        <main class="flex-1 md:ml-56 p-1 md:p-6 lg:p-8 pb-16 md:pb-4">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-secondary">
                            Products
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">Manage your product listings</p>
                    </div>
                    <Link
                        href="/product/create"
                        class="hidden md:flex items-center gap-2 px-6 py-2.5 bg-secondary text-primary font-semibold rounded-lg shadow-md hover:bg-secondary-dark hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5"
                    >
                        Add Product
                    </Link>
                </div>

                <!-- Filters -->
                <div class="mb-6">
                    <Filters
                        :current-status="filters.status"
                        :current-sort="filters.sort"
                        @update:status="val => filters.status = val"
                        @update:sort="val => filters.sort = val"
                        @update:search="val => filters.search = val"
                    />
                </div>

                <!-- Table -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <div v-if="products.length === 0" class="flex flex-col items-center justify-center py-16 px-4">
                        <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-700 mb-1">No products found</h3>
                        <p class="text-sm text-gray-500">Try adjusting your filters or add a new product</p>
                    </div>

                    <div v-else class="overflow-x-auto px-2">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                            <tr>
                                <th class="px-1 lg:px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">S/N</th>
                                <th class="px-1 lg:px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                                <th class="px-1 lg:px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Brand</th>
                                <th class="px-1 lg:px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Category</th>
                                <th class="hidden md:table-cell px-3 lg:px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Vendor</th>
                                <th class="px-1 lg:px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Price</th>
                                <th class="hidden lg:table-cell px-1 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tag</th>
                                <th class="px-1 lg:px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Action</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                            <tr v-for="(product, index) in products" :key="product.id" class="hover:bg-gray-100 rounded-md transition-colors duration-150 group">
                                <td class="px-1 lg:px-4 py-4 text-sm text-gray-700 font-medium">{{ index + 1 }}</td>
                                <td class="px-1 lg:px-4 py-4 text-sm text-gray-800 font-medium">
                                    {{ product.name.length > 15 ? product.name.slice(0, 15) + '...' : product.name }}
                                </td>
                                <td class="px-1 lg:px-4 py-4 text-sm text-gray-700">{{ product.brand }}</td>
                                <td class="px-1 lg:px-4 py-4 text-sm text-gray-700">{{ product.category }}</td>
                                <td class="hidden md:table-cell px-3 lg:px-6 py-4 text-sm text-gray-700">{{ product.vendor }}</td>
                                <td class="px-1 lg:px-4 py-4 text-sm text-gray-700">₦{{ product.price }}</td>
                                <td class="hidden lg:table-cell px-1 py-4 text-sm text-gray-700">
                                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 ring-1 ring-red-200">
                                            {{ product.tag }}
                                        </span>
                                </td>
                                <td class="px-1 flex flex-col justify-between lg:px-4 py-4 text-sm">
                                    <button @click="viewProduct(product)" class="py-1 px-1 text-blue-500 hover:text-blue-600 font-medium transition-colors duration-150 group-hover:underline">View</button>
                                    <button @click="editProduct(product)" class="py-1 px-1 text-green-500 hover:text-green-600 font-medium transition-colors duration-150 group-hover:underline">Edit</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div v-if="products.length > 0" class="mt-4 text-sm text-gray-600 text-center md:text-left">
                    Showing <span class="font-semibold text-gray-800">{{ products.length }}</span> product{{ products.length !== 1 ? 's' : '' }}
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import Filters from "@/Components/Filters.vue"
import {Link} from "@inertiajs/vue3";
// import ViewProduct from "@/Components/ViewProduct.vue"
import AddEditProduct from "@/Components/Vendor/AddEditProduct.vue"
import axios from "axios"

const props = defineProps({
    items: Array
})

const products = ref(props.items)
const showViewProductModal = ref(false)
const productToView = ref({})
const showAddProductModal = ref(false)
const productToEdit = ref({})

const viewProduct = (product) => {
    productToView.value = product
    showViewProductModal.value = true
}

const editProduct = (product) => {
    productToEdit.value = product
    showAddProductModal.value = true
}

const filters = ref({
    status: 'all',
    sort: 'newest',
    search: ''
})

// Example fetch for products if needed
const fetchProducts = async () => {
    try {
        const response = await axios.get('/fetch/products', {
            params: {
                status: filters.value.status,
                sort: filters.value.sort,
                search: filters.value.search
            }
        })
        products.value = response.data
    } catch (error) {
        console.error('Error fetching products:', error)
    }
}

watch(() => [filters.value.status, filters.value.sort, filters.value.search], fetchProducts)
</script>
