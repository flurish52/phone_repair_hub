<template>
    <div class="w-full max-w-4xl mt-6">
        <SectionHeading title="List of vendors near you" />

        <!-- Vendors Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:flex justify-center items-center">
            <!-- Browse all vendors -->
            <div
                class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 p-4 flex items-center"
            >
                <Link
                    href="/accessories"
                    class="flex items-center gap-4 flex-1"
                >
                    <div class="w-10 h-10 bg-secondary rounded-md"></div>
                    <div>
                        <h2 class="text-secondary font-semibold text-base md:text-lg">
                            Browse from all vendors near you
                        </h2>
                    </div>
                </Link>
            </div>

            <!-- Individual vendor -->
            <div
                v-for="vendor in items.data"
                :key="vendor.id"
                class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 p-4 flex items-center"
            >
                <Link
                    :href="`/vendor/${vendor.slug}`"
                    class="flex items-center gap-4 flex-1"
                >
                    <img
                        :src="vendor.image_url || '/images/placeholder.png'"
                        :alt="vendor.name"
                        class="w-16 h-16 object-cover rounded-lg"
                    />
                    <div class="flex flex-col flex-1">
                        <h2 class="text-secondary font-semibold text-base md:text-lg">
                            {{ vendor.name }}
                        </h2>
                        <p class="text-gray-500 text-sm truncate">
                            {{ vendor.address || 'No description' }}
                        </p>
                        <div
                            class="flex justify-between items-center text-gray-700 font-medium text-sm md:text-base"
                        >
                            <p>Total products:</p>
                            <p>{{ vendor.products_count }}</p>
                        </div>
                    </div>
                </Link>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-6 space-x-2">
            <button
                v-for="link in items.links"
                :key="link.label"
                :disabled="!link.url"
                @click="goToPage(link.url)"
                :class="[
          'px-3 py-1 border rounded-md',
          link.active
            ? 'bg-secondary text-white border-secondary'
            : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100'
        ]"
            >
                <span v-html="link.label"></span>
            </button>
        </div>
    </div>
</template>


<script setup>
import SectionHeading from "@/Components/Partials/SectionHeading.vue";
import { Link } from "@inertiajs/vue3";

defineProps({
    items: {
        type: Object,
        required: true
    },
    vendor: {
        type: Object,
        required: true
    }
});

// function goToPage(url) {
//     if (url) {
//         Inertia.get(url, {}, { preserveState: true });
//     }
// }
</script>
