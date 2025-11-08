<template>
    <li class="py-2 border-b hover:bg-primary-dark px-3 rounded-md ">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <button
                    v-if="hasChildren"
                    @click="toggle"
                    class="text-secondary text-lg leading-none">
                    {{ expanded ? '-' : '+' }}
                </button>
                <span class="text-secondary">{{ category.name }}</span>
            </div>

            <div class="flex gap-2">
                <button class="text-blue-600" @click="$emit('edit', category)">Edit</button>
                <button class="text-red-600" @click="$emit('delete', category.id)">Delete</button>
            </div>
        </div>

        <ul v-if="expanded && children.length" class="pl-6 border-l ml-3 mt-2">
            <CategoryItem
                v-for="child in children"
                :key="child.id"
                :category="child"
                :allCategories="allCategories"
                @edit="$emit('edit', $event)"
                @delete="$emit('delete', $event)"
            />
        </ul>
    </li>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
    category: Object,
    allCategories: Array,
})

const expanded = ref(false)
function toggle() {
    expanded.value = !expanded.value
}

const children = computed(() =>
    props.allCategories.filter(c => c.parent_id === props.category.id)
)

const hasChildren = computed(() => children.value.length > 0)
</script>
