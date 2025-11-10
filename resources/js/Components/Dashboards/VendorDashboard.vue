<template>
    <div class="flex flex-col min-h-screen bg-primary">

        <CopyLink
            v-if="$page.props.auth.user.role === 'vendor'"
            class="md:self-end" :storeSlug="`${$page.props.auth.user.slug}`" />

        <main class="flex-1 p-1 md:p-6 lg:p-8 pb-16 md:pb-4">
            <div class="max-w-7xl mx-auto">

                <!-- Header -->
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-secondary">Products</h1>
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
                        :statuses="statuses"
                        :sorts="sorts"
                        :current-status="filters.status"
                        :current-sort="filters.sort"
                        @update:status="val => filters.status = val"
                        @update:sort="val => filters.sort = val"
                        @update:search="val => filters.search = val"
                    />
                </div>

                <!-- Product Table -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">

                    <!-- Empty state -->
                    <div v-if="products.length === 0" class="flex flex-col items-center justify-center py-16 px-4">
                        <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-700 mb-1">No products found</h3>
                        <p class="text-sm text-gray-500">Try adjusting your filters or add a new product</p>
                    </div>

                    <!-- Product list -->
                    <div v-else class="overflow-x-auto px-2">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                            <tr>
                                <th class="px-1 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">S/N</th>
                                <th class="px-1 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                                <th class="px-1 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider hidden md:table-cell">Total Stock</th>
<!--                                <th class="px-1 hidden md:table-cell py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Avg. Engineer Price</th>-->
                                <th class="px-1 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Avg. Regular Price</th>
                                <th class="px-1 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-1 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                            <tr v-for="(product, index) in products" :key="product.id"
                                class="hover:bg-gray-100 transition-colors duration-150">
                                <td class="px-1 py-4 text-sm text-gray-700 font-medium">{{ index + 1 }}</td>
<!--                                <td class="px-1 py-4 text-sm text-gray-800 font-medium">-->
<!--                                </td>-->
                                <td class="px-1 py-4 text-sm text-gray-800 font-medium whitespace-normal break-words max-w-[150px]">
                                    {{ product.name.length > 15 ? product.name.slice(0, 15) + '...' : product.name }}
<!--                                    {{ // product.name }}-->
                                </td>

                                <!-- Total stock -->
                                <td class="px-1 py-4 text-sm text-gray-700 hidden md:table-cell">
                                    {{ totalStock(product) }}
                                </td>

                                <!-- Price range -->
<!--                                <td class="px-1 py-4 hidden md:table-cell text-sm text-gray-700">-->
<!--                                    ₦{{ minEngPrice(product) }} - ₦{{ maxEngPrice(product) }}-->
<!--                                </td>-->
                                <td class="px-1 py-4 text-sm text-gray-700">
                                    ₦{{ minPrice(product) }} - ₦{{ maxPrice(product) }}
                                </td>

                                <!-- Status -->
                                <td class="px-1 py-4 text-sm font-medium">
                                        <span :class="productStatusClass(product)">
                                            {{ productStatus(product) }}
                                        </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-1 py-4 flex flex-col md:flex-row gap-1">
                                    <Link
                                        :href="`/product/${product.user.id}/${product.id}/view`"
                                        class="py-1 px-1 text-blue-500 hover:text-blue-600 font-medium transition-colors duration-150"
                                    > View </Link>
                                    <Link
                                        :href="`/product/update/${product.id}/edit`"
                                        class="py-1 px-1 text-green-500 hover:text-green-600 font-medium transition-colors duration-150"
                                    >Edit</Link>

                                    <button
                                        @click="deleteProduct(product.id)"
                                        class="py-1 px-1 text-red-500 hover:text-red-600 font-medium transition-colors duration-150"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6" role="img" aria-label="Delete">
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            <rect x="4" y="6" width="16" height="14" rx="2" ry="2" />
                                            <line x1="10" y1="11" x2="10" y2="17" />
                                            <line x1="14" y1="11" x2="14" y2="17" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div v-if="products.length > 0" class="mt-4 text-sm text-gray-600 text-center md:text-left">
                    Showing <span class="font-semibold text-gray-800">{{ products.length }}</span>
                    product{{ products.length !== 1 ? 's' : '' }}
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Link } from '@inertiajs/vue3'
import Filters from '@/Components/Filters.vue'
import axios from 'axios'
import CopyLink from "@/Components/Vendor/CopyLink.vue";

const props = defineProps({
    items: Array
})

const products = ref(props.items)
const filters = ref({
    status: 'all',
    sort: 'newest',
    search: ''
})

const sorts = [
    { key: 'newest', label: 'Newest first' },
    { key: 'oldest', label: 'Oldest first' }
]
const statuses = [
    { key: 'all', label: 'All' },
    { key: 'active', label: 'Active' },
    { key: 'inactive', label: 'In active' },
]
const showViewProductModal = ref(false)
const productToView = ref({})

const viewProduct = (product) => {
    productToView.value = product
    showViewProductModal.value = true
}

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

// Helpers
const minPrice = (product) => Math.min(...product.variants.map(v => v.regular_price))
const maxPrice = (product) => Math.max(...product.variants.map(v => v.regular_price))
const minEngPrice = (product) => Math.min(...product.variants.map(v => v.engineer_price))
const maxEngPrice = (product) => Math.max(...product.variants.map(v => v.engineer_price))
const totalStock = (product) => product.variants.reduce((sum, v) => sum + (v.stock || 0), 0)
const productStatus = (product) =>
    product.variants.some(v => v.status === 'active') ? 'Active' : 'Inactive'
const productStatusClass = (product) =>
    productStatus(product) === 'Active'
        ? 'text-green-600 bg-green-100 px-2 py-1 rounded-full text-xs'
        : 'text-red-600 bg-red-100 px-2 py-1 rounded-full text-xs'

function deleteProduct(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        axios.delete(`/product/delete/${id}`)
            .then(() => {
                alert('Product deleted successfully')
                window.location.reload()
            })
            .catch(() => {
                alert('Failed to delete product')
            })
    }
}
</script>
