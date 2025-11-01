<template>

    <div class="mt-6 ">
        <SectionHeading title="Browse Products from Top Vendors"/>
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 w-full   ">
        <div
            v-for="product in items"
            :key="product.id"
            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200"
        >
        <Link :href="`/accessories?product=${product.slug}`">
            <img :src="product.image_url" :alt="product.name" class="w-full h-24 object-cover" />
            <div class="p-4">
                <h2 class="text-sm md:text-base font-semibold text-secondary">{{ product.name }}</h2>
                <p class="text-xs text-gray-500 mt-1 truncate">{{ product.brand }} - {{ product.category }}</p>
                <div class="flex justify-between">

                <p class="mt-2 font-medium text-secondary-dark">₦{{ product.price}}</p>
                    <button class="mt-2 border-2 border-secondary px-1 font-medium text-secondary rounded-md">Details</button>
                </div>
            </div>
        </Link>
    </div>
    </div>
    </div>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
import SectionHeading from "@/Components/Partials/SectionHeading.vue";

defineProps({
    items: {
        type: Array,
        required: true
    }
});
</script>
