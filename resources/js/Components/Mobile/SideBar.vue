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
        <ul class="flex-1 overflow-y-auto p-3 space-y-1 shadow-md">
            <Link  :href="`/${topUrl}`" class="px-3 py-2" >All {{ title }}</Link>
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
import {Link} from "@inertiajs/vue3";

defineProps({
    items: Array,
    title: String,
    urlPrefix: String,
    topUrl: String,
})

defineEmits(["close"])
</script>

<style scoped>
/* Sidebar scrollbar */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: transparent;
}

::-webkit-scrollbar-thumb {
    background: #c5c5c5;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a3a3a3;
}

/* Firefox */
* {
    scrollbar-width: thin;
    scrollbar-color: #c5c5c5 transparent;
}
</style>
