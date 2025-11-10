<template>
    <AuthenticatedLayout>
        <div class="max-w-6xl mx-auto p-2 md:p-8 pb-16">
            <!-- Product Header -->
            <div class="flex flex-col md:flex-row gap-6 border-b pb-6 mb-6">
                <!-- Main Image -->
                <div class="w-full md:w-1/2">
                    <img
                        :src="`/storage/${product.images.find(img => img.is_primary)?.image_path || product.images[0]?.image_path}`"
                        alt="Product Image"
                        class="rounded-xl shadow-md w-full h-auto object-cover my-2"
                    />
                    <div class="mt-3 flex gap-2 overflow-x-auto">
                        <img
                            v-for="img in product.images"
                            :key="img.id"
                            :src="`/storage/${img.image_path}`"
                            alt="Product image"
                            class="w-20 h-20 rounded-md object-cover border"
                        />
                    </div>
                </div>

                <!-- Product Info -->
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900 break-words">{{ product.name }}</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ product.brand?.name || 'No Brand' }} | {{ product.category?.name || 'Uncategorized' }}
                    </p>

                    <!-- Condition and Negotiable -->
                    <div class="mt-4 space-y-2">
                        <p class="text-sm text-gray-700">
                            Condition:
                            <span class="font-semibold text-gray-900">
                                {{ product.condition ? product.condition.charAt(0).toUpperCase() + product.condition.slice(1) : 'Not specified' }}
                            </span>
                        </p>
                        <p class="text-sm text-gray-700">
                            Negotiable:
                            <span :class="product.is_negotiable ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold'">
                                {{ product.is_negotiable ? 'Yes' : 'No' }}
                            </span>
                        </p>
                    </div>

                    <!-- Description -->
                    <p class="mt-4 text-gray-700 whitespace-pre-line break-words">
                        {{ product.description }}
                    </p>

                    <!-- Tags -->
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span
                            v-for="tag in product.tags"
                            :key="tag.id"
                            class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-medium border border-gray-300"
                        >
                            {{ tag.name }}
                        </span>
                    </div>

                    <!-- Vendor Info -->
                    <div class="mt-4 text-sm text-gray-500 space-y-1">
                        <p>Sold by: {{ product.user.name }}</p>
                        <p>Location: {{ product.user.address }}</p>
                    </div>
                </div>
            </div>

            <!-- Variants Section -->
            <div>
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Available Variants</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div
                        v-for="variant in product.variants"
                        :key="variant.id"
                        class="border rounded-xl p-4 shadow-sm hover:shadow-md transition"
                    >
                        <h3 class="font-semibold text-gray-800">{{ variant.name }}</h3>
                        <p class="text-sm text-gray-500">SKU: {{ variant.sku }}</p>

                        <div class="mt-2 space-y-1">
                            <p class="text-sm text-gray-700">Engineer Price: ₦{{ variant.engineer_price }}</p>
                            <p class="text-sm text-gray-700">Regular Price: ₦{{ variant.regular_price }}</p>
                            <p class="text-sm text-gray-700">Stock: {{ variant.stock }}</p>
                            <p
                                class="text-xs mt-1"
                                :class="variant.status === 'active' ? 'text-green-600' : 'text-red-600'"
                            >
                                {{ variant.status }}
                            </p>
                        </div>

                        <!-- Attributes -->
                        <ul class="mt-3 text-sm text-gray-600 space-y-1">
                            <li v-for="attr in variant.attributes" :key="attr.key">
                                {{ attr.key }}:
                                <span class="font-medium text-gray-800">{{ attr.value }}</span>
                            </li>
                        </ul>

                        <!-- Images -->
                        <div class="mt-3 flex gap-2 overflow-x-auto">
                            <img
                                v-for="img in variant.images"
                                :key="img.id"
                                :src="`/storage/${img.image_path}`"
                                alt="Variant Image"
                                class="w-16 h-16 rounded-md object-cover border"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating Actions -->
        <div class="fixed bottom-4 right-4 flex gap-3">
            <Link
                href="/dashboard"
                class="bg-primary text-xs md:text-base border-2 border-secondary text-secondary px-4 py-2 rounded-lg shadow-md hover:bg-secondary hover:text-primary text-center"
            >
                Back to Listings
            </Link>
            <Link
                :href="`/product/update/${product.id}/edit`"
                class="bg-secondary text-xs md:text-base text-primary px-4 py-2 rounded-lg shadow-md hover:bg-primary hover:text-secondary text-center"
            >
                Edit Product
            </Link>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    product: Object
});
</script>
