<template>
    <div>
        <div
            class="bg-primary border-2 border-dashed p-4 text-center cursor-pointer"
            @click="fileInput.click()"
            @dragover.prevent
            @drop.prevent="handleDrop"
        >
            <input type="file" multiple accept="image/*" class="hidden" ref="fileInput" @change="handleFiles" />
            <p>Drop images here or click to upload</p>
        </div>

        <div v-if="images.length" class="grid grid-cols-3 gap-2 bg-primary p-2 rounded-md mt-2">
            <div v-for="(img, index) in images" :key="img.id" class="relative border p-1">
                <img :src="img.preview" class="w-full h-44 object-cover" />
                <button @click="removeImage(index)" class="absolute top-1 right-1 bg-red-500 text-white text-xs px-1">X</button>
                <button
                    v-if="!img.primary"
                    @click="setPrimary(index)"
                    type="button"
                    class="absolute bottom-1 left-1 bg-blue-500 text-white text-xs px-1"
                >
                    Make primary
                </button>
                <span v-else class="absolute bottom-1 left-1 bg-green-500 text-white text-xs px-1">Primary</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onUnmounted } from 'vue'

const props = defineProps({
    modelValue: Array,
    existingImages: { type: Array, default: () => [] }
})

const emit = defineEmits(['update:modelValue', 'markDelete'])
const images = ref([])
const fileInput = ref(null)
let imageId = 0

watch(
    () => props.existingImages,
    (val) => {
        if (!val) return
        // Avoid resetting if it’s already same reference
        if (val === images.value) return

        const mapped = val.map((img, i) => {
            let preview = img.preview
            if (!preview) {
                if (img.image_path) preview = img.image_path.startsWith('http') ? img.image_path : `/storage/${img.image_path}`
                else if (typeof img === 'string') preview = img.includes('http') ? img : `/storage/${img}`
            }
            return {
                id: img.id || imageId++,
                file: img.file || null,
                preview,
                primary: i === 0,
                position: i,
                is_existing: !!img.id
            }
        })

        images.value = [...mapped]
    },
    { immediate: true }
)


function handleFiles(event) {
    const files = Array.from(event.target.files)
    addFiles(files)
    event.target.value = ''
}

function handleDrop(e) {
    const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'))
    addFiles(files)
}

async function addFiles(files) {
    for (const file of files) {
        images.value.push({
            id: Date.now() + Math.floor(Math.random() * 1000),
            file,
            preview: URL.createObjectURL(file),
            primary: images.value.length === 0,
            position: images.value.length,
            is_existing: false
        })
    }
    emitUpdate()
}


function compress(file) {
    return new Promise((resolve) => {
        const img = new Image()
        const reader = new FileReader()
        reader.onload = (e) => (img.src = e.target.result)
        img.onload = () => {
            const canvas = document.createElement('canvas')
            const ctx = canvas.getContext('2d')
            const scale = Math.min(1920 / img.width, 1080 / img.height, 1)
            canvas.width = img.width * scale
            canvas.height = img.height * scale
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height)
            canvas.toBlob(
                (b) => resolve(new File([b], file.name, { type: 'image/jpeg' })),
                'image/jpeg',
                0.7
            )
        }
        reader.readAsDataURL(file)
    })
}

function removeImage(index) {
    const img = images.value[index]
    if (img.is_existing) emit('markDelete', img.id)
    if (img.file) URL.revokeObjectURL(img.preview)
    const wasPrimary = img.primary
    images.value.splice(index, 1)
    if (wasPrimary && images.value.length) images.value[0].primary = true
    reorderPositions()
    emitUpdate()
}

function setPrimary(index) {
    images.value.forEach((img, i) => (img.primary = i === index))
    emitUpdate()
}

function reorderPositions() {
    images.value.forEach((img, i) => (img.position = i))
}

function emitUpdate() {
    emit('update:modelValue', images.value.map(img => ({ ...img })))
}

onUnmounted(() => {
    images.value.forEach(img => img.file && URL.revokeObjectURL(img.preview))
})
</script>
