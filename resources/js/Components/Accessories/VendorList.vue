<template>
    <div class="flex flex-col w-full max-w-4xl mt-6 space-y-4">
        <SectionHeading title="List of vendors near you"/>
        <div
            v-for="vendor in items"
            :key="vendor.id"
            class="flex flex-col sm:flex-row sm:items-center justify-between bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 p-4 w-full"
        >
            <!-- Vendor Info -->
            <Link
                :href="`/${vendor.slug}`"
                class="flex  sm:flex-row sm:items-center gap-4 flex-1">
                <img
                    :src="vendor.image_url"
                    :alt="vendor.name"
                    class="sm:w-10 h-10 object-cover rounded-lg"
                />
                <div class="flex flex-col items-start">
                    <h2 class="text-secondary font-semibold text-base md:text-lg">{{ vendor.name }}</h2>
                    <p class="text-gray-500 text-sm">
                        {{ vendor.address && vendor.address.length > 100 ? vendor.address.slice(0, 10) + '...' : vendor.address || 'No description' }}
                    </p>
                    <div class="flex justify-between items-center sm:mt-0 text-gray-700 font-medium text-sm md:text-base">
                         <p>Products:</p>  <p>{{ vendor.productsCount }}</p>
                    </div>
                </div>
            </Link>

            <!-- Products Count -->
        </div>
    </div>
</template>

<script setup>
import SectionHeading from "@/Components/Partials/SectionHeading.vue";
import {Link} from "@inertiajs/vue3";

defineProps({
    items: {
        type: Array,
        required: true
    }
});
</script>
