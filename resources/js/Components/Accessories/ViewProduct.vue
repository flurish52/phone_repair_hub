<template>
    <div
         @click.self="$emit('close')"
        v-if="product"
         class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
        <div class="bg-white rounded-2xl shadow-lg w-11/12 max-w-md relative">
            <!-- Close icon -->
            <button
                @click="$emit('close')"
                class="absolute top-3 right-3 text-gray-600 hover:text-secondary text-xl hover:cursor-pointer"
            >
                ×
            </button>

            <!-- Product Image -->
            <div class="relative">
                <img
                    :src="product?.image_url"
                    :alt="product?.name"
                    class="w-full h-64 object-cover rounded-t-2xl"
                />
                <!-- Product Tag -->
                <span
                    v-if="product?.tag"
                    class="absolute top-3 left-3 bg-secondary text-primary text-xs font-semibold px-2 py-1 rounded"
                >
          {{ product?.tag }}
        </span>
            </div>

            <!-- Product Details -->
            <div class="p-5 space-y-3 text-secondary-dark">
                <h2 class="text-lg font-semibold">{{ product?.name }}</h2>
                <p class="text-sm text-gray-600">Vendor: {{ product?.vendor || 'Unknown Vendor' }}</p>
                <p class="text-sm text-gray-600">Vendor: {{ product.description}}</p>
                <p class="text-base font-medium">₦{{ product?.price.toLocaleString() }}</p>
            </div>

            <!-- Bottom Close Button -->
            <div class="p-4 border-t text-center">
                <button
                    @click="$emit('close')"
                    class="bg-secondary text-primary px-5 py-2 rounded-lg hover:bg-secondary-dark transition"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    product: {
        type: Object,
        required: false,
    },
});

defineEmits(['close']);
</script>
