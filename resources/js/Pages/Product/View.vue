<template>
    <AuthenticatedLayout>
        <div class="max-w-6xl md:ml-64 mx-auto p-1 pb-16 md:p-8">
            <!-- Product Header -->
            <div class="flex flex-col md:flex-row gap-6 border-b pb-6 mb-6">
                    <div class="w-full md:w-1/2">
                        <img
                            :src="`/storage/${product.images.find(img => img.is_primary)?.image_path ||
                             product.images[0]?.image_path}`"
                            alt="Product Image"
                            class="rounded-xl shadow-md w-full h-auto object-cover  my-2"
                        />
                    </div>

                    <div class="mt-3 flex md:flex-col gap-2 overflow-x-auto">
                    <img
                        v-for="img in product.images"
                        :key="img.id"
                        :src="`/storage/${img.image_path}`"
                        alt="Product image"
                        class="w-20 h-20 rounded-md object-cover border"
                    />
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900">{{ product.name }}</h1>
                    <p class="text-sm text-gray-500 mt-1">{{ product.brand.name }} | {{ product.category.name }}</p>

                    <p class="mt-4 text-gray-700">{{ product.description }}</p>

                    <div class="mt-4 flex flex-wrap gap-2">
          <span
              v-for="tag in product.tags"
              :key="tag.id"
              class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-medium border border-gray-300"
          >
            {{ tag.name }}
          </span>
                    </div>

                    <p class="mt-4 text-sm text-gray-500">Sold by: {{ product.user.name }}</p>
                    <p class="text-sm text-gray-500">Location: {{ product.user.address }}</p>
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

                        <div class="mt-2">
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

                        <!-- Variant Attributes -->
                        <ul class="mt-3 text-sm text-gray-600 space-y-1">
                            <li v-for="attr in variant.attributes" :key="attr.key">
                                {{ attr.key }}: <span class="font-medium text-gray-800">{{ attr.value }}</span>
                            </li>
                        </ul>

                        <!-- Variant Images -->
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
        <div class="ml-64 fixed top-20 right-6 flex  gap-3 flex-row">
            <Link
                href="/dashboard"
                class="bg-primary text-xs md:text-base border-2 border-secondary text-secondary px-4 py-2 rounded-lg shadow-md hover:bg-secondary hover:text-primary text-center"
            >
                Back to Listings
            </Link>
            <Link
                :href="`/product/update/${product.id}`"
                class="bg-secondary text-xs md:text-base text-primary px-4 py-2 rounded-lg shadow-md hover:bg-primary hover:text-secondary text-center"
            >
                Edit product
            </Link>
        </div>

    </AuthenticatedLayout>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    product: Object
})
</script>
