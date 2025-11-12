<template>
    <div class="space-y-4">
        <!-- Main -->
        <select v-model="main" class="w-full border rounded p-2">
            <option :value="null">Select Main Category</option>
            <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
        </select>

        <!-- Sub -->
        <div v-if="main || sub">
            <select v-model="sub" class="w-full border rounded p-2">
                <option :value="null">Select Subcategory</option>
                <option v-for="c in subs" :key="c.id" :value="c.id">{{ c.name }}</option>
            </select>
            <span class="text-xs italic text-secondary">(optional)</span>
        </div>

        <!-- Sub-Sub -->
        <div v-if="sub || subSub">
            <select v-model="subSub" class="w-full border rounded p-2">
                <option :value="null">Select Sub-Subcategory</option>
                <option v-for="c in subSubs" :key="c.id" :value="c.id">{{ c.name }}</option>
            </select>
            <span class="text-xs italic text-secondary">(optional)</span>
        </div>


        <!-- Display -->
        <div v-if="final" class="p-2 border rounded bg-gray-50">
            <p class="text-sm text-gray-600">Selected Category:</p>
            <p class="font-medium">{{ final.name }}</p>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, nextTick } from 'vue'

const props = defineProps({
    modelValue: [String, Number],
    categories: { type: Array, required: true }
})
const emit = defineEmits(['update:modelValue'])

const main = ref(null)
const sub = ref(null)
const subSub = ref(null)

// Compute subcategories dynamically
const subs = computed(() => {
    const mainCat = props.categories.find(c => c.id === main.value)
    return mainCat?.children || []
})
const subSubs = computed(() => {
    const subCat = subs.value.find(c => c.id === sub.value)
    return subCat?.children || []
})

// Watch main/sub/subSub to update downstream selections
watch(main, val => {
    if (val !== main.value) return
    sub.value = sub.value && subs.value.find(s => s.id === sub.value) ? sub.value : null
    subSub.value = subSub.value && subSubs.value.find(s => s.id === subSub.value) ? subSub.value : null
    emit('update:modelValue', main.value)
})

watch(sub, val => {
    if (!subSubs.value.find(s => s.id === subSub.value)) subSub.value = null
    emit('update:modelValue', sub.value || main.value)
})

watch(subSub, val => {
    emit('update:modelValue', subSub.value || sub.value || main.value)
})

// Compute final selected category
const final = computed(() => {
    const id = subSub.value || sub.value || main.value
    if (!id) return null
    const find = (list, id) => {
        for (const c of list) {
            if (c.id === id) return c
            if (c.children?.length) {
                const f = find(c.children, id)
                if (f) return f
            }
        }
    }
    return find(props.categories, id)
})

// Initialize from modelValue


onMounted(async () => {
    if (!props.modelValue) return

    const findPath = (list, id, path = []) => {
        for (const c of list) {
            if (c.id === id) return [...path, c]
            if (c.children?.length) {
                const res = findPath(c.children, id, [...path, c])
                if (res) return res
            }
        }
    }

    const path = findPath(props.categories, props.modelValue) || []

    await nextTick() // ensure reactivity triggers for computed subs/subSubs
    main.value = path[0]?.id || null
    sub.value = path[1]?.id || null
    subSub.value = path[2]?.id || null
})

</script>
