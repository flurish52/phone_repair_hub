<template>
    <li>
        <div
            class="flex items-center justify-between px-3 py-2 rounded hover:bg-secondary hover:text-primary cursor-pointer transition"
        >
            <Link :href="`/${urlPrefix}/${item.slug}`">
                {{ item.name }}
            </Link>

            <button
                v-if="item.children && item.children.length"
                @click.stop="toggle"
                class="text-sm"
            >
                <span v-if="!open">＋</span>
                <span v-else>－</span>
            </button>
        </div>

        <transition name="fade">
            <ul
                v-if="open && item.children && item.children.length"
                class="ml-5 border-l border-gray-400 pl-3 mt-1 space-y-1"
            >
                <SideBarItemsList
                    v-for="child in item.children"
                    :key="child.id"
                    :item="child"
                    :url-prefix="urlPrefix"
                />
            </ul>
        </transition>
    </li>
</template>

<script setup>
import { ref } from "vue"
import { Link } from "@inertiajs/vue3"

defineProps({
    item: Object,
    urlPrefix: String,
})

const open = ref(false)
const toggle = () => (open.value = !open.value)
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: all 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(-5px);
}
</style>
