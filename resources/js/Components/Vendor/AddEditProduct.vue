<template>
    <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg max-h-[80vh] md:max-h-[90vh]  flex flex-col">

            <!-- Header -->
            <div class="flex-shrink-0 px-6 py-4 border-b flex justify-between items-center">
                <h2 class="text-xl font-bold">{{ isEdit ? 'Edit Product' : 'Add Product' }}</h2>
                <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">✕</button>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto px-6 py-4">
                <form @submit.prevent="submitForm" class="space-y-4">

                    <div>
                        <label class="block mb-1 font-medium">Product Name</label>
                        <input v-model="form.name" type="text" class="w-full border px-3 py-2 rounded" required/>
                        <p v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name[0] }}</p>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Brand</label>
                        <input v-model="form.brand" type="text" class="w-full border px-3 py-2 rounded" required/>
                        <p v-if="errors.brand" class="text-red-500 text-sm mt-1">{{ errors.brand[0] }}</p>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Category</label>
                        <input v-model="form.category" type="text" class="w-full border px-3 py-2 rounded" required/>
                        <p v-if="errors.category" class="text-red-500 text-sm mt-1">{{ errors.category[0] }}</p>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Vendor</label>
                        <input v-model="form.vendor" type="text" class="w-full border px-3 py-2 rounded" required/>
                        <p v-if="errors.vendor" class="text-red-500 text-sm mt-1">{{ errors.vendor[0] }}</p>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Price</label>
                        <input v-model.number="form.price" type="number" class="w-full border px-3 py-2 rounded" required/>
                        <p v-if="errors.price" class="text-red-500 text-sm mt-1">{{ errors.price[0] }}</p>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Tag</label>
                        <input v-model="form.tag" type="text" class="w-full border px-3 py-2 rounded"/>
                        <p v-if="errors.tag" class="text-red-500 text-sm mt-1">{{ errors.tag[0] }}</p>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Description</label>
                        <textarea v-model="form.description" class="w-full border px-3 py-2 rounded" rows="3"></textarea>
                        <p v-if="errors.description" class="text-red-500 text-sm mt-1">{{ errors.description[0] }}</p>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Image</label>
                        <input type="file" @change="handleImage" accept="image/*" class="w-full"/>
                        <p v-if="errors.image" class="text-red-500 text-sm mt-1">{{ errors.image[0] }}</p>
                        <div v-if="preview" class="mt-2">
                            <img :src="preview" class="h-32 rounded border" />
                        </div>
                    </div>

                </form>
            </div>

            <!-- Footer -->
            <div class="flex-shrink-0 px-6 py-4 border-t bg-gray-50 rounded-b-lg flex justify-end space-x-3">
                <button type="button" @click="$emit('close')" class="px-4 py-2 rounded border hover:bg-gray-100">Cancel</button>
                <button type="submit" @click="submitForm"
                        class="bg-secondary text-primary px-4 py-2 rounded hover:bg-primary hover:text-secondary border-2 border-secondary">
                    {{ isEdit ? 'Update Product' : 'Save Product' }}
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref, watch } from 'vue'
import axios from 'axios'
import imageCompression from 'browser-image-compression'
import { router } from '@inertiajs/vue3'

const emit = defineEmits(['close'])

const props = defineProps({
    show: Boolean,
    product: Object // optional, for editing
})

const form = reactive({
    name: '',
    brand: '',
    category: '',
    vendor: '',
    price: null,
    image: null,
    tag: '',
    description: ''
})

const errors = reactive({})
const preview = ref(null)
const isEdit = ref(false)

watch(() => props.product, (product) => {
    if (product) {
        isEdit.value = true
        Object.assign(form, {
            name: product.name,
            brand: product.brand,
            category: product.category,
            vendor: product.vendor,
            price: product.price,
            tag: product.tag,
            description: product.description
        })
        preview.value = product.image_url || null
    } else {
        isEdit.value = false
        Object.keys(form).forEach(key => form[key] = key === 'price' ? null : '')
        preview.value = null
    }
}, { immediate: true })

const handleImage = async (e) => {
    const file = e.target.files[0]
    if (!file) return

    // Compress image
    try {
        const compressedFile = await imageCompression(file, { maxSizeMB: 2, maxWidthOrHeight: 1024 })
        form.image = compressedFile

        // Preview
        const reader = new FileReader()
        reader.onload = (event) => preview.value = event.target.result
        reader.readAsDataURL(compressedFile)
    } catch (err) {
        console.error('Image compression error:', err)
    }
}

const submitForm = async () => {
    errors.value = {}

    const data = new FormData()
    for (const key in form) {
        if (form[key] !== null) data.append(key, form[key])
    }

    const url = isEdit.value ? `/products/${props.product.id}` : '/products'
    const method = isEdit.value ? 'post' : 'post'

    try {
        await axios({
            method,
            url,
            data,
            headers: { 'Content-Type': 'multipart/form-data' }
        })
        router.visit('/products')
        emit('close')
    } catch (err) {
        if (err.response?.data?.errors) {
            Object.assign(errors, err.response.data.errors)
        } else {
            console.error(err)
        }
    }
}
</script>
