<template>
    <div class="w-full md:max-w-4xl mt-6 px-6 mx-auto">
        <SectionHeading title="List of vendors near you" />

        <!-- Vendors Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-4 md:mx-12">

            <!-- Browse all vendors -->
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 p-4 flex flex-col">
                <Link href="/accessories" class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-secondary rounded-md flex-shrink-0"></div>
                    <div class="flex-1">
                        <h2 class="text-secondary font-semibold text-base">
                            Browse from all vendors near you
                        </h2>
                    </div>
                </Link>
            </div>

            <!-- Individual vendors -->
            <div
                v-for="vendor in items.data"
                :key="vendor.id"
                class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 p-4 flex"
            >
                <Link
                    :href="`/vendor/${vendor.slug}`"
                    class="flex items-center gap-4 w-96 break-words"
                >
                    <img
                        :src="`/storage/${vendor.avatar}` || '/images/placeholder.png'"
                        :alt="vendor.name"
                        class="w-16 h-16 object-cover rounded-lg flex-shrink-0"
                    />
                    <div class="flex flex-col flex-1 min-w-0">
                        <h2 class="text-secondary font-semibold">
                            {{ vendor.name }}
                        </h2>
                        <p class="text-gray-500 text-sm ">
                            {{ vendor.address || 'No description' }}
                        </p>
                        <div class="flex justify-between items-center text-gray-700 font-medium text-sm md:text-base mt-1">
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

</script>
