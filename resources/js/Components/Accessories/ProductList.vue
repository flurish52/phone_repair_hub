<template>
    <div class="mt-8 md:ml-64">
        <div class="mb-6" v-if="vendor && vendor?.name">
            <SectionHeading class="" :title="`Products from ${vendor.name}`" />
            <p class="ml-8 text-secondary italic text-sm md:text-base font-medium">
                {{ vendor.address }}
            </p>
        </div>

        <SectionHeading v-else class="mb-6" title="Browse Products from Top Vendors" />

        <div
            v-if="items.data && items.data.length"
            class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 w-full"
        >
            <div
                v-for="product in items.data"
                :key="product.id"
                class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100"
            >
                <Link :href="`/products/${product.user.slug}/${product.slug}/details`" class="block h-full">
                    <div class="overflow-hidden">
                        <img
                            :src="
                                product.images?.[0]?.image_path
                                    ? `/storage/${product.images[0].image_path}`
                                    : '/images/placeholder.png'
                            "
                            :alt="product.name"
                            class="w-full h-44 md:h-64 object-cover transition-transform duration-500 hover:scale-105"
                        />
                    </div>
                    <div class="p-4 relative">
                        <p class="text-secondary font-semibold text-sm line-clamp-2 transition-colors duration-200">
                            {{ product.name }}
                        </p>

                        <p class="text-xs text-gray-500 mt-1 truncate">
                            {{ product.brand?.name || 'Unknown Brand' }} -
                            {{ product.category?.name || 'Uncategorized' }}
                        </p>
                        <div class="flex flex-col md:flex-row justify-between items-center mt-3">
<!--                            <p-->
<!--                                v-if="$page.props.auth.user && ($page.props.auth.user.role === 'engineer' ||-->
<!--                                $page.props.auth.user.role === 'vendor')"-->
<!--                                class="font-medium text-secondary"-->
<!--                            >-->
<!--                                Engr. ₦{{ product?.variants[0]?.engineer_price }}-->
<!--                            </p>-->
                            <p
                               class="font-medium text-secondary"
                            >
                                Price: ₦{{ product?.variants[0]?.regular_price }}
                            </p>
                            <button
                                class="w-full md:w-auto mt-2 md:mt-0 border-2 border-secondary px-3 py-1.5 font-medium text-secondary rounded-lg text-xs md:text-sm hover:bg-secondary hover:text-white transition-all duration-300 transform hover:scale-105 active:scale-95"
                            >
                                Details
                            </button>
                        </div>
                    </div>
                </Link>
            </div>
        </div>

        <div v-else class="text-center text-gray-500 mt-8 py-12">
            <div class="text-lg font-medium animate-pulse">No products found.</div>
        </div>

        <!-- Pagination -->
        <div
            v-if="items.links && items.links.length"
            class="flex justify-center mt-8 space-x-2"
        >
            <Link
                v-for="link in items.links"
                :key="link.label"
                :href="link.url || '#'"
                v-html="link.label"
                class="px-4 py-2 border rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-105"
                :class="{
                    'bg-secondary text-white border-secondary shadow-md': link.active,
                    'text-secondary border-gray-300 hover:bg-gray-50 hover:border-secondary': !link.active,
                    'opacity-50 pointer-events-none cursor-not-allowed': !link.url,
                }"
            />
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import SectionHeading from "@/Components/Partials/SectionHeading.vue";

defineProps({
    items: {
        type: Object,
        required: true,
    },

    vendor: {
        type: Object,
        required: true,
    },
});
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Smooth animations */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}

/* Hover effects for better interactivity */
.hover\:shadow-xl:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Image loading animation */
img {
    transition: transform 0.5s ease-in-out;
}
</style>
