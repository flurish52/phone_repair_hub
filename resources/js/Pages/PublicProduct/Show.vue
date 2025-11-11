<template>
    <GuestLayout>
        <GuestNavBar />

        <!-- Fixed Tabs -->
        <div class="fixed top-12 left-0 md:pl-64 right-0 z-40 bg-primary shadow-lg">
            <Tabs
                :tabs="['Products', 'Vendors']"
                :activeTab="currentTab"
                :vendor_brands="vendor_brands"
                :vendor_cats="vendor_cats"
            />
        </div>

        <!-- Main Content -->
        <div class="max-w-6xl mt-16 md:mt-24 md:ml-64 mx-auto p-4 md:p-6 space-y-6">

            <!-- Top Section: Image + Details -->
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Product Image -->
                <div class="md:w-1/2">
                    <img
                        :src="activeImage"
                        :alt="product.name"
                        class="w-full h-96 object-contain rounded-lg shadow-md"
                    />
                    <div class="flex gap-2 mt-2 overflow-x-auto   md:overflow-y-auto">
                        <img
                            v-for="img in product.images"
                            :key="img.id"
                            :src="`/storage/${img.image_path}`"
                            :alt="product.name"
                            @click="activeImage = `/storage/${img.image_path}`"
                            class="w-16 h-16 md:w-20 md:h-20 object-cover rounded-lg cursor-pointer border-2 transition-all"
                            :class="activeImage === `/storage/${img.image_path}` ? 'border-secondary' : 'border-transparent'"
                        />
                    </div>
                </div>

                <!-- Product Details -->
                <div class="md:w-1/2 flex flex-col gap-3">
                    <h1 class="text-2xl md:text-3xl font-semibold text-secondary">{{ product.name }}</h1>

                    <div class="flex flex-wrap gap-4 text-sm text-gray-700">
                        <p>
                            <span class="font-medium text-secondary">Condition:</span>
                            {{ product.condition || 'Not specified' }}
                        </p>
                        <p>
                            <span class="font-medium text-secondary">Negotiable:</span>
                            {{ product.is_negotiable ? 'Yes' : 'No' }}
                        </p>
                    </div>

                    <div v-if="product.tags?.length" class="flex flex-wrap gap-2 mt-2">
                        <span
                            v-for="tag in product.tags"
                            :key="tag.id"
                            class="bg-secondary text-white text-xs md:text-sm px-2 py-0.5 rounded"
                        >
                            {{ tag.name }}
                        </span>
                    </div>

                    <div class="flex gap-4 text-gray-600 mt-2">
                        <p>
                            <span class="font-medium text-secondary">Brand:</span>
                            {{ product.brand?.name || 'Unknown' }}
                        </p>
                        <p>
                            <span class="font-medium text-secondary">Category:</span>
                            {{ product.category?.name || 'Uncategorized' }}
                        </p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg text-gray-700 mt-4">
                        <h2 class="font-semibold text-secondary text-lg mb-2">Description</h2>
                        <p>{{ product.description }}</p>
                    </div>
                </div>
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
                                <p
                                    v-for="attr in JSON.parse(variant.attributes)"
                                    :key="attr.key"
                                >
                                    {{ attr.key }}: {{ attr.value }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4 items-center text-gray-700">
                        <p>Price: ₦{{ variant.regular_price }}</p>
                        <p>Stock: {{ variant.stock }}</p>
                    </div>
                </div>
            </div>

            <!-- Vendor Info -->
            <div class="mt-6 bg-white p-4 rounded-lg shadow-sm">
                <h2 class="font-semibold text-secondary text-lg mb-2">Vendor details</h2>
                <p class="font-medium text-secondary">{{ product.user?.name }}</p>
                <p class="text-gray-600 flex items-center gap-2">
                    Phone: {{ product.user?.phone }}
                    <a
                        v-if="product.user?.phone"
                        :href="`https://wa.me/${formatPhoneNumber(product.user.phone).replace('+', '')}?text=${encodeURIComponent(
    `Hello, I saw your product ${product.name}, listed on ${siteName} and I am interested. Is it still available?`
  )}`"
                        target="_blank"
                        rel="noopener"
                        title="Chat on WhatsApp"
                    >
                        <img
                            src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg"
                            alt="WhatsApp"
                            class="w-10 h-10"
                        />
                    </a>

                </p>

                <p class="text-gray-600">{{ product.user?.address }}</p>
                <p class="text-gray-600">Email: {{ product.user?.email }}</p>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import GuestNavBar from "@/Components/Partials/GuestNavBar.vue"
import Tabs from "@/Components/Partials/Tab.vue"
import { ref, onMounted } from "vue"
import GuestLayout from "@/Layouts/GuestLayout.vue"

const activeImage = ref("")

const props = defineProps({
    product: { type: Object, required: true },
    vendor_brands: Array,
    vendor_cats: Array,
})
const siteName = window.location.hostname

onMounted(() => {
    if (props.product.images?.length) {
        activeImage.value = `/storage/${props.product.images[0].image_path}`
    }
})

const formatPhoneNumber = (phone) => {
    if (!phone) return ''
    let num = phone.toString().trim()

    // Remove spaces, dashes, parentheses
    num = num.replace(/[\s\-\(\)]/g, '')

    // If it already starts with +234, return as is
    if (num.startsWith('+234')) return num

    // If it starts with 234 but no +, add +
    if (num.startsWith('234')) return '+' + num

    // If it starts with 0, replace it with +234
    if (num.startsWith('0')) return '+234' + num.substring(1)

    // If none match, assume it's a local Nigerian number
    return '+234' + num
}

</script>

<style scoped>
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}
.shadow-sm {
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}
.shadow-md {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
.hover\:shadow-lg:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
</style>
