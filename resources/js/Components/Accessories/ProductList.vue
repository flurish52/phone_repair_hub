<template>
    <div class="mt-8  md:ml-64">
        <div class="mb-6"  v-if="vendor && vendor?.name" >
        <SectionHeading class="" :title="`Products from ${vendor.name}`" />
            <p class="ml-8 text-secondary italic text-sm md:text-base font-medium text-gray-600">
                {{ vendor.address }}
            </p>

        </div>
        <SectionHeading v-else class="mb-6" title="Browse Products from Top Vendors" />

        <div
            v-if="items.data && items.data.length"
            class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 w-full"
        >
            <div
                v-for="product in items.data"
                :key="product.id"
                class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200"
            >
                <Link :href="`/products/${product.user.slug}/${product.slug}/details`">
                    <img
                        :src="
                            product.images?.[0]?.image_path
                                ? `/storage/${product.images[0].image_path}`
                                : '/images/placeholder.png'
                        "
                        :alt="product.name"
                        class="w-full h-32 object-cover"
                    />
                    <div class="p-4 relative">
                        <p class="text-gray-800 font-semibold text-sm line-clamp-2">
                            {{ product.name }}
                        </p>

                        <p class="text-xs text-gray-500 mt-1 truncate">
                            {{ product.brand?.name || 'Unknown Brand' }} -
                            {{ product.category?.name || 'Uncategorized' }}
                        </p>
                        <div class="flex flex-col md:flex-row justify-between items-center mt-2">
                            <p
                                v-if="$page.props.auth.user && ($page.props.auth.user.role === 'engineer' ||
                                $page.props.auth.user.role === 'vendor')"
                                class="font-medium text-secondary-dark">
                               Engr. ₦{{ product?.variants[0]?.engineer_price }}
                            </p>
                            <p v-else
                               class="font-medium text-secondary-dark">
                                Price: ₦{{ product?.variants[0]?.regular_price }}
                            </p>
                            <br>
                            <button
                                class="w-full md:w-auto  absolute bottom-0 md:static border-2 border-secondary px-2 py-0.5 font-medium text-secondary rounded-md text-xs md:text-sm hover:bg-secondary hover:text-white transition"
                            >
                                Details
                            </button>
                        </div>
                    </div>
                </Link>
            </div>
        </div>

        <div v-else class="text-center text-gray-500 mt-6">
            No products found.
        </div>

        <!-- Pagination -->
        <div v-if="items.links && items.links.length"
             class="flex justify-center mt-8 space-x-2">
            <Link
                v-for="link in items.links"
                :key="link.label"
                :href="link.url || '#'"
                v-html="link.label"
                class="px-3 py-1 border rounded-md text-sm"
                :class="{
                    'bg-secondary text-white': link.active,
                    'text-gray-600 hover:bg-gray-100': !link.active,
                    'opacity-50 pointer-events-none': !link.url,
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

</style>
