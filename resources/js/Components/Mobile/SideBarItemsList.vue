<template>
    <li ref="root" class="group">
        <div
            class="flex items-center justify-between px-4 py-1 rounded-lg transition-all duration-200"
            :class="[
                isActive
                    ? 'bg-secondary text-primary border-l-4 border-primary shadow-sm'
                    : 'hover:bg-gray-50 hover:border-l-4 hover:border-secondary text-secondary'
            ]"
        >
            <Link
                :href="`/${urlPrefix}/${item.slug}`"
                preserve-scroll="true"
                class="flex-1 min-w-0"
            >
                <div class="flex space-y-1 justify-start items-start">
                    <div class="w-8 h-8 mx-1   bg-secondary/20 rounded-md ">
                        <img v-if="item?.avatar" class="h-full w-full rounded-md" :src="`/storage/${item.avatar}`" alt="">
                    </div>
                    <div class="flex flex-col items-start space-x-2">
                        <span class=" text-sm">{{ item.name }}</span>
                    <span
                        v-if="item?.address"
                        class="text-xs text-secondary-dark truncate"
                    >
                        {{ item.address }}
                    </span>
                        <span
                            v-if="item?.products_count"
                            class="inline-flex items-start  rounded-full text-xs text-secondary font-thin italic"
                        >
                            {{ item.products_count }} ads
                        </span>
                    </div>
                </div>
            </Link>

            <button
                v-if="item.children && item.children.length"
                @click.stop="toggle"
                class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-md transition-colors hover:bg-gray-200 text-gray-500 hover:text-gray-700 ml-2"
                :class="open ? 'bg-gray-100' : ''"
            >
                <svg
                    class="w-3 h-3 transition-transform duration-200"
                    :class="open ? 'rotate-180' : ''"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>

        <transition
            enter-active-class="transition-all duration-300 ease-out"
            leave-active-class="transition-all duration-200 ease-in"
            enter-from-class="opacity-0 max-h-0"
            enter-to-class="opacity-100 max-h-96"
            leave-from-class="opacity-100 max-h-96"
            leave-to-class="opacity-0 max-h-0"
        >
            <ul
                v-if="open && item.children && item.children.length"
                class="ml-6 border-l border-gray-200 pl-3 mt-1 space-y-1 overflow-hidden"
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
import { ref, computed, watch, onMounted, nextTick } from "vue"
import { Link, usePage } from "@inertiajs/vue3"

const props = defineProps({
    item: Object,
    urlPrefix: String,
})

const open = ref(false)
const page = usePage()
const currentSlug = computed(() => page.url.split('/').filter(Boolean).pop())
const root = ref(null)

function hasActiveDescendant(item, slug) {
    if (!item.children) return false
    return item.children.some(child =>
        child.slug === slug || hasActiveDescendant(child, slug)
    )
}

const isActive = computed(() => currentSlug.value === props.item.slug)

function checkIfShouldOpen() {
    if (isActive.value || hasActiveDescendant(props.item, currentSlug.value)) {
        open.value = true
    }
}

const toggle = () => (open.value = !open.value)

async function scrollIfNeeded() {
    await nextTick()
    if (!root.value) return
    if (isActive.value || hasActiveDescendant(props.item, currentSlug.value)) {
        root.value.scrollIntoView({
            block: "center",
            inline: "nearest",
            behavior: "smooth"
        })
    }
}

onMounted(() => {
    checkIfShouldOpen()
    scrollIfNeeded()
})

watch(() => page.url, async () => {
    checkIfShouldOpen()
    await scrollIfNeeded()
})
</script>
