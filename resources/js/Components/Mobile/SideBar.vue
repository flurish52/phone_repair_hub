<template>
    <aside
        class="h-full md:ml-56 w-64 bg-primary text-secondary border-l border-gray-200 flex flex-col shadow-lg"
    >
        <!-- Header -->
        <div class="flex items-center justify-between px-4 py-3 border-b">
            <h2 class="text-lg font-semibold">{{ title }}</h2>
            <button
                @click="$emit('close')"
                class="text-secondary hover:text-gray-200"
            >
                ✕
            </button>
        </div>

        <!-- Category List -->
        <ul class="flex-1 overflow-y-auto p-3 space-y-1">
            <SideBarItemsList
                v-for="item in items"
                :key="item.id"
                :item="item"
                :url-prefix="urlPrefix"
            />
        </ul>
    </aside>
</template>

<script setup>
import SideBarItemsList from "@/Components/Mobile/SideBarItemsList.vue";

defineProps({
    items: Array,
    title: String,
    urlPrefix: String,
})

defineEmits(["close"])
</script>
