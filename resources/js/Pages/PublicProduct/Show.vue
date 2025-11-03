<template>
    <!-- Fixed Tabs at top -->
    <GuestNavBar />
    <div class="fixed top-16 left-0  md:pl-64 right-0 z-40 bg-primary shadow-md">
        <Tabs
            :tabs="['Accessories', 'Vendors' ]"
            :activeTab="currentTab"
        />
    </div>
        <div class="max-w-5xl py-12 mt-16 md:mt-24 md:ml-64 mx-auto p-4 md:p-6 space-y-6">
            <!-- Product Title -->
            <h1 class="text-2xl md:text-3xl font-semibold text-secondary">
                {{ product.name }}
            </h1>

            <!-- Tags -->
            <div v-if="product.tags?.length" class="flex flex-wrap gap-2 mt-2">
                <span
                    v-for="tag in product.tags"
                    :key="tag.id"
                    class="bg-secondary text-white text-xs md:text-sm px-2 py-0.5 rounded"
                >
                    {{ tag.name }}
                </span>
            </div>

            <!-- Brand & Category -->
            <div class="flex md:flex-row md:items-center gap-4 text-gray-600">
                <p><span class="font-medium text-secondary">Brand:</span> {{ product.brand?.name || 'Unknown' }}</p>
                <p><span class="font-medium text-secondary">Category:</span> {{ product.category?.name || 'Uncategorized' }}</p>
            </div>

            <!-- Product Images -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <img
                    v-for="img in product.images"
                    :key="img.id"
                    :src="`/storage/${img.image_path}`"
                    :alt="product.name"
                    class="w-full h-64 md:h-80 object-cover rounded-lg shadow-sm"
                />
            </div>

            <!-- Description -->
            <div class="bg-gray-50 p-4 rounded-lg text-gray-700">
                <h2 class="font-semibold text-secondary text-lg mb-2">Description</h2>
                <p>{{ product.description }}</p>
            </div>

            <!-- Variants -->
            <div v-if="product.variants?.length" class="space-y-4">
                <h2 class="font-semibold text-secondary text-lg">Variants</h2>
                <div
                    v-for="variant in product.variants"
                    :key="variant.id"
                    class="border rounded-lg p-4 flex flex-col md:flex-row md:items-center justify-between gap-4"
                >
                    <div class="flex gap-4 items-center">
                        <img
                            v-if="variant.images?.length"
                            :src="`/storage/${variant.images[0].image_path}`"
                            :alt="variant.name"
                            class="w-20 h-20 object-cover rounded"
                        />
                        <div>
                            <p class="font-medium text-secondary">{{ variant.name }}</p>
                            <div v-if="variant.attributes" class="text-gray-600 text-sm mt-1">
                                <p v-for="attr in JSON.parse(variant.attributes)" :key="attr.key">
                                    {{ attr.key }}: {{ attr.value }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-4 items-center text-gray-700">
                        <p v-if="
                        $page.props.auth.user &&
                        ($page.props.auth.user.role === 'vendor'
                        || $page.props.auth.user.role === 'engineer')"
                        >
                            Engr Price: ₦{{ variant.regular_price }}</p>
                        <p>Price: ₦{{ variant.regular_price }}</p>
                        <p>Stock: {{ variant.stock }}</p>
                    </div>
                </div>
            </div>

            <!-- Vendor Info -->
            <div class="mt-6 bg-white p-4 rounded-lg shadow-sm">
                <h2 class="font-semibold text-secondary text-lg mb-2">Vendor</h2>
                <p class="font-medium text-secondary">{{ product.user?.name }}</p>
                <p class="text-gray-600">{{ product.user?.address }}</p>
                <p class="text-gray-600">Phone: {{ product.user?.phone }}</p>
                <p class="text-gray-600">Email: {{ product.user?.email }}</p>
            </div>
        </div>
</template>

<script setup>
import GuestNavBar from "@/Components/Partials/GuestNavBar.vue";
import Tabs from "@/Components/Partials/Tab.vue";
defineProps({
    product: {
        type: Object,
        required: true
    }
})
</script>
