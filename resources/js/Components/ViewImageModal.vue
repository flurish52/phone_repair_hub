<script setup>
import { ref, watch, defineProps, defineEmits } from 'vue'

const props = defineProps({
    images: { type: Array, required: true },
    show: { type: Boolean, required: true },
    currentIndex: { type: Number, default: 0 }
})

const emit = defineEmits(['close'])

const currentIndex = ref(props.currentIndex)
const currentImage = ref('')

// Whenever show changes or index changes, update currentImage
watch(
    [() => props.show, currentIndex],
    () => {
        if (props.show && props.images.length) {
            currentImage.value = props.images[currentIndex.value]
        }
    },
    { immediate: true }
)

// Watch for prop change if parent updates currentIndex dynamically
watch(
    () => props.currentIndex,
    (val) => {
        if (typeof val === 'number') currentIndex.value = val
    }
)

const closeModal = () => emit('close')

const prev = () => {
    if (props.images.length > 1) {
        currentIndex.value =
            (currentIndex.value - 1 + props.images.length) % props.images.length
    }
}

const next = () => {
    if (props.images.length > 1) {
        currentIndex.value = (currentIndex.value + 1) % props.images.length
    }
}
</script>

<template>
    <transition name="fade">
        <div
            v-if="show"
            @click.self="closeModal"
            class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center p-4"
        >
            <div class="relative max-w-full max-h-full w-full md:w-auto flex items-center justify-center">
                <button
                    v-if="images.length > 1"
                    @click.stop="prev"
                    class="absolute left-2 md:left-4 top-1/2 -translate-y-1/2 text-white text-2xl md:text-3xl z-10 bg-black/30 hover:bg-black/50 rounded-full w-10 h-10 flex items-center justify-center"
                >‹</button>

                <img
                    :src="currentImage.includes('http') ? currentImage : `/storage/${currentImage}`"
                    class="max-h-[90vh] md:max-h-[80vh] w-auto object-contain rounded-md shadow-lg"
                />

                <button
                    v-if="images.length > 1"
                    @click.stop="next"
                    class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 text-white text-2xl md:text-3xl z-10 bg-black/30 hover:bg-black/50 rounded-full w-10 h-10 flex items-center justify-center"
                >›</button>

                <button
                    @click="closeModal"
                    class="absolute top-2 right-2 md:top-4 md:right-4 text-white text-xl md:text-2xl bg-black/30 hover:bg-black/50 rounded-full w-8 h-8 flex items-center justify-center"
                >×</button>
            </div>
        </div>
    </transition>
</template>
