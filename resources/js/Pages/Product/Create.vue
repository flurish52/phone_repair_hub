<template>
    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto p-4 md:p-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ editingProduct ? 'Edit Product' : 'Create New Product' }}
                    </h1>
                    <p class="text-gray-600 mt-1">Add or update a product in your inventory</p>
                </div>

                <div class="flex gap-3 hidden md:flex">
                    <Link
                        href="/product/create"
                        class="px-4 py-2 border-2 border-secondary text-secondary bg-primary text-white rounded-lg hover:bg-primary-dark transition"
                    >
                        New Product
                    </Link>

                    <Link
                        href="/dashboard"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition"
                    >
                        Back to Listings
                    </Link>
                </div>

            </div>


            <div class="bg-primary rounded-xl shadow-sm border border-secondary overflow-hidden">
                <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-8 p-6">

                    <!-- Product Info -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-2 h-6 bg-blue-600 rounded-full"></div>
                            <h3 class="text-lg font-semibold text-secondary">Product Information</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">Product Name</label>
                                <input v-model="form.name" type="text"
                                       class="w-full px-4 py-3 border border-secondary rounded-lg focus:ring-2 focus:ring-blue-500 bg-primary"
                                       placeholder="Enter product name" required/>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">Brand</label>
                                <select v-model="form.brand_id"
                                        class="w-full px-4 py-3 border border-secondary rounded-lg focus:ring-2 focus:ring-blue-500 bg-primary">
                                    <option value="">Select brand</option>
                                    <option v-for="brand in $page.props.brands" :key="brand.id" :value="brand.id">
                                        {{ brand.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-secondary mb-2">Description</label>
                            <textarea v-model="form.description" rows="4"
                                      class="w-full px-4 py-3 border border-secondary rounded-lg focus:ring-2 focus:ring-blue-500 bg-primary"
                                      placeholder="Describe your product..."></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">Category</label>
                                <select v-model="form.category_id"
                                        class="w-full px-4 py-3 border border-secondary rounded-lg focus:ring-2 focus:ring-blue-500 bg-primary">
                                    <option value="">Select category</option>
                                    <option v-for="category in $page.props.categoriesForForm" :key="category.id"
                                            :value="category.id">{{ category.name }}
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">Tags</label>
                                <select v-model="form.tags" multiple
                                        class="w-full px-4 py-3 border border-secondary rounded-lg focus:ring-2 focus:ring-blue-500 bg-primary">
                                    <option v-for="tag in $page.props.tags" :key="tag.id" :value="tag.name">{{
                                            tag.name
                                        }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Product Images -->
                        <div>
                            <label class="block text-sm font-medium text-secondary mb-2">Product Images</label>
                            <ImageUpload
                                v-model="form.product_images"
                                :existingImages="editingProduct?.images"
                                compact
                                @markDelete="markDeletedProductImage"
                            />
                        </div>
                    </div>

                    <!-- Variants -->
                    <div class="space-y-6 pt-6 border-t border-secondary">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-6 bg-green-600 rounded-full"></div>
                                <h3 class="text-lg font-semibold text-secondary">Product Variants</h3>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div v-for="(variant, index) in form.variants" :key="index"
                                 class="border border-secondary rounded-xl p-6 bg-primary-dark">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="font-semibold text-secondary">Variant {{ index + 1 }}</span>
                                    <button v-if="form.variants.length > 1" type="button" @click="removeVariant(index)"
                                            class="text-red-600 text-sm hover:text-red-700">Remove
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-secondary mb-2">Variant
                                            Name</label>
                                        <input v-model="variant.name" type="text" placeholder="e.g. Red - Large"
                                               class="w-full px-3 py-2 border border-secondary rounded-lg focus:ring-2 focus:ring-blue-500 bg-primary"/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-secondary mb-2">Engineer
                                            Price</label>
                                        <input v-model="variant.engineer_price" type="number" step="0.01"
                                               placeholder="0.00"
                                               class="w-full px-3 py-2 border border-secondary rounded-lg focus:ring-2 focus:ring-blue-500 bg-primary"/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-secondary mb-2">Regular
                                            Price</label>
                                        <input v-model="variant.regular_price" type="number" step="0.01"
                                               placeholder="0.00"
                                               class="w-full px-3 py-2 border border-secondary rounded-lg focus:ring-2 focus:ring-blue-500 bg-primary"/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-secondary mb-2">Stock</label>
                                        <input v-model="variant.stock" type="number" placeholder="Quantity"
                                               class="w-full px-3 py-2 border border-secondary rounded-lg focus:ring-2 focus:ring-blue-500 bg-primary"/>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-secondary mb-2">Status</label>
                                        <select v-model="variant.status"
                                                class="w-full px-3 py-2 border border-secondary rounded-lg focus:ring-2 focus:ring-blue-500 bg-primary">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Attributes -->
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-secondary mb-2">Attributes</label>
                                    <div v-for="(attr, i) in variant.attributes" :key="i" class="flex gap-3 mb-2">
                                        <input v-model="attr.key" type="text" placeholder="Key (e.g. Color)"
                                               class="w-1/2 px-3 py-2 border border-secondary rounded-lg focus:ring-2 focus:ring-blue-500 bg-primary"/>
                                        <input v-model="attr.value" type="text" placeholder="Value (e.g. Red)"
                                               class="w-1/2 px-3 py-2 border border-secondary rounded-lg focus:ring-2 focus:ring-blue-500 bg-primary"/>
                                        <button type="button" @click="removeAttribute(index, i)"
                                                class="text-red-600 hover:text-red-700 text-sm w-8 h-8 flex items-center justify-center">
                                            ×
                                        </button>
                                    </div>
                                    <button type="button" @click="addAttribute(index)"
                                            class="px-3 py-2 text-sm bg-secondary text-primary rounded-lg hover:bg-secondary-dark transition">
                                        Add Attribute
                                    </button>
                                </div>

                                <!-- Variant Images -->
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-secondary mb-2">Variant Images</label>
                                    <ImageUpload
                                        v-model="variant.images"
                                        :existingImages="variant.images"
                                        compact
                                        @markDelete="(id) => markDeletedVariantImage(index, id)"
                                    />
                                </div>
                            </div>
                        </div>

                        <button type="button" @click="addVariant"
                                class="px-4 py-2 bg-secondary text-primary rounded-lg hover:bg-secondary-dark transition">
                            Add Variant
                        </button>
                    </div>

                    <div class="flex justify-end pt-6 border-t border-secondary">
                        <button
                            type="submit"
                            :disabled="processing"
                            class="flex items-center justify-center px-8 py-3 bg-secondary-dark text-white rounded-lg hover:bg-secondary disabled:opacity-50 transition"
                        >
                            <span v-if="processing" class="flex items-center gap-2">
                              <svg
                                  class="animate-spin h-5 w-5 text-white"
                                  xmlns="http://www.w3.org/2000/svg"
                                  fill="none"
                                  viewBox="0 0 24 24"
                              >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                ></path>
                              </svg>
                              {{ editingProduct ? 'Updating...' : 'Creating...' }}
                            </span>
                                                    <span v-else>
                              {{ editingProduct ? 'Update Product' : 'Create Product' }}
                            </span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {router, useForm} from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import ImageUpload from "@/Components/Vendor/ImageUploader.vue";
import {Link} from "@inertiajs/vue3";
import axios from 'axios'
import {ref} from "vue";

    let processing =  ref(false)
const props = defineProps({
    editingProduct: Object
})


const deletedProductImages = ref([])
const deletedVariantImages = ref({}) // keyed by variant index

function markDeletedProductImage(id) {
    if (!deletedProductImages.value.includes(id))
        deletedProductImages.value.push(id)
}

function markDeletedVariantImage(variantIndex, id) {
    if (!deletedVariantImages.value[variantIndex]) deletedVariantImages.value[variantIndex] = []
    if (!deletedVariantImages.value[variantIndex].includes(id)) {
        deletedVariantImages.value[variantIndex].push(id)
    }
}

// Preload product images and variant images
const form = useForm({
    name: props.editingProduct?.name || '',
    description: props.editingProduct?.description || '',
    brand_id: props.editingProduct?.brand_id || '',
    category_id: props.editingProduct?.category_id || '',
    tags: props.editingProduct?.tags?.map(t => t.name) || [],
    product_images: props.editingProduct?.images?.map((img, i) => ({
        id: img.id,
        file: null,
        preview: img.image_path.includes('/storage/')
            ? img.image_path
            : `/storage/${img.image_path}`,
        primary: img.primary,
        position: i
    })) || [],
    variants: props.editingProduct?.variants?.map(v => ({
        ...v,
        images: v.images?.map((img, i) => ({
            id: img.id,
            file: img.file ?? null,
            preview: img.image_path.startsWith('http') ? img.image_path : `/storage/${img.image_path}`,
            primary: img.primary,
            position: i,
            is_existing: true
        })) || [],
        preview: []
    })) || [{
        name: '',
        engineer_price: '',
        regular_price: '',
        stock: 0,
        status: 'active',
        attributes: [{key: '', value: ''}],
        images: [],
        preview: []
    }]
})

function addVariant() {
    form.variants.push({
        name: '',
        engineer_price: '',
        regular_price: '',
        stock: 0,
        status: 'active',
        attributes: [{key: '', value: ''}],
        images: [],
        preview: []
    })
}

function removeVariant(index) {
    form.variants.splice(index, 1)
}

function addAttribute(index) {
    form.variants[index].attributes.push({key: '', value: ''})
}

function removeAttribute(variantIndex, attrIndex) {
    form.variants[variantIndex].attributes.splice(attrIndex, 1)
}


function submit() {
    processing.value = true
    const formData = new FormData()
    formData.append('name', form.name)
    formData.append('description', form.description)
    formData.append('brand_id', form.brand_id)
    formData.append('category_id', form.category_id)
    if (deletedProductImages.value) {
        deletedProductImages.value.forEach((id) => {
            formData.append('product_deleted_images[]', id)
        })
    }

    form.tags.forEach((tag, i) => formData.append(`tags[${i}]`, tag))

    form.product_images.forEach((img, i) => {
        if (img.file) {
            formData.append(`product_images[${i}][file]`, img.file)
        } else if (img.id) {
            formData.append(`product_images[${i}][id]`, img.id)
            formData.append(`product_images[${i}][image_path]`, img.preview)
        }
        formData.append(`product_images[${i}][position]`, img.position)
        formData.append(`product_images[${i}][primary]`, img.primary ? 1 : 0)
    })

    form.variants.forEach((variant, i) => {
        if (props.editingProduct) {
            formData.append(`variants[${i}][id]`, variant.id ? variant.id : '')
        }
        formData.append(`variants[${i}][name]`, variant.name)
        formData.append(`variants[${i}][engineer_price]`, variant.engineer_price)
        formData.append(`variants[${i}][regular_price]`, variant.regular_price)
        formData.append(`variants[${i}][stock]`, variant.stock)
        formData.append(`variants[${i}][status]`, variant.status)

        variant.attributes.forEach((attr, j) => {
            formData.append(`variants[${i}][attributes][${j}][key]`, attr.key)
            formData.append(`variants[${i}][attributes][${j}][value]`, attr.value)
        })

        variant.images.forEach((img, j) => {
            if (img.file) {
                formData.append(`variants[${i}][images][${j}][file]`, img.file)
            } else if (img.id) {
                formData.append(`variants[${i}][images][${j}][id]`, img.id)
                formData.append(`variants[${i}][images][${j}][image_path]`, img.preview)
            }
            formData.append(`variants[${i}][images][${j}][position]`, img.position ?? j)
            formData.append(`variants[${i}][images][${j}][primary]`, img.primary ? 1 : 0)
        })

        if (deletedVariantImages.value[i]) {
            deletedVariantImages.value[i].forEach((id, j) => {
                formData.append(`variants[${i}][deleted_images][${j}]`, id)
            })
        }
    })


    const url = props.editingProduct
        ? route('product.update', props.editingProduct.id)
        : route('product.store')

    const method = props.editingProduct ? 'post' : 'post'

    axios({
        method,
        url,
        data: formData,
        headers: {'Content-Type': 'multipart/form-data'}
    })
        .then(response => {
            alert('Product saved successfully')
            router.visit(window.location.href, {preserveScroll: true})
        })
        .catch(error => {
            if (error.response) {
                const data = error.response.data
                const msg = data.message || 'Something went wrong while saving product'
                alert(msg)
                console.error(data)
            } else {
                alert('Network error. Try again.')
            }
        })
    processing.value = false
}

</script>


