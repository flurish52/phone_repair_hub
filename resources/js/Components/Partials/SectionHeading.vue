<template>
    <div class="w-full max-w-7xl mx-auto px-4 mb-2">
        <h2 class="text-lg md:text-2xl font-semibold text-secondary border-l-4 border-secondary pl-3">
            {{ title }}
        </h2>
    </div>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        required: true
    }
});
</script>

