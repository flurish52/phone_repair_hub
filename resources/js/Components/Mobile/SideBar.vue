<template>
    <aside
        class="h-full md:ml-56 w-64 bg-secondary text-primary border-l border-gray-200 flex flex-col shadow-lg"
    >
        <!-- Header -->
        <div class="flex items-center justify-between px-4 py-3 border-b">
            <h2 class="text-lg font-semibold text-primary">{{ title }}</h2>
            <button
                @click="$emit('close')"
                class="text-primary hover:text-gray-200"
            >
                ✕
            </button>
        </div>

        <!-- List -->
        <ul class="flex-1 overflow-y-auto p-3 space-y-2">
            <li
                v-for="item in items"
                :key="item.id"
            >
                <Link
                    :href="`/accessories/${item.slug}`"
                    class="block px-3 py-2 rounded text-primary hover:bg-primary hover:text-secondary transition"
                >
                    {{ item.name }}
                </Link>
            </li>
        </ul>
    </aside>
</template>

<script setup>
import { Link } from "@inertiajs/vue3"

defineProps({
    items: Array,
    title: String
})

defineEmits(['close'])
</script>
