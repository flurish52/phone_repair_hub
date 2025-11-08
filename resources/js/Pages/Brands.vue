<template>
    <AuthenticatedLayout>
        <div class="p-6 grid md:grid-cols-2 gap-6">
            <!-- Brand List -->
            <div class="bg-primary rounded-2xl shadow p-4">

                <div class="">
                    <h2 class="text-secondary text-lg font-semibold">Brands</h2>
                    <p class="text-secondary text-sm">
                        Add the brands you work with. Click the button to create or manage your brand list.
                    </p>
                      <hr class="my-3 py-2"/>
                </div>
                <div class="md:hidden mt-3">
                    <button
                        class="w-full bg-secondary text-white px-4 py-2 rounded-lg"
                        @click="showForm = true">
                        Add Brand
                    </button>
                </div>

                <ul>
                    <li
                        v-for="brand in vendor_brands"
                        :key="brand.id"
                        class="flex justify-between hover:bg-primary-dark px-3 rounded-md items-center border-b py-2">
                        <span class="text-secondary">{{ brand.name }}</span>
                        <div class="flex gap-2">
                            <button
                                @click="editBrand(brand)"
                                class="text-blue-600 text-sm">
                                Edit
                            </button>
                            <button
                                @click="deleteBrand(brand.id)"
                                class="text-red-600 text-sm">
                                Delete
                            </button>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Desktop Form -->
            <div class="bg-primary rounded-2xl shadow p-4 hidden md:block">
                <h2 class="text-secondary text-lg font-semibold mb-4">
                    {{ form.id ? 'Edit Brand' : 'Add New Brand' }}
                </h2>
                <form @submit.prevent="saveBrand">
                    <input
                        v-model="form.name"
                        type="text"
                        placeholder="Brand Name"
                        class="w-full border p-2 rounded mb-3 focus:outline-none"
                        required
                    />
                    <button
                        type="submit"
                        class="bg-secondary text-white w-full py-2 rounded-lg"
                        :disabled="loading">
                        {{ loading ? 'Saving...' : (form.id ? 'Update' : 'Save') }}
                    </button>
                </form>
            </div>

            <!-- Mobile Modal -->
            <div
                v-if="showForm"
                class="fixed inset-0 bg-black/50 flex items-center justify-center md:hidden">
                <div class="bg-primary p-6 rounded-xl w-11/12 max-w-sm">
                    <h2 class="text-secondary text-lg font-semibold mb-4">
                        {{ form.id ? 'Edit Brand' : 'Add New Brand' }}
                    </h2>
                    <form @submit.prevent="saveBrand">
                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="Brand Name"
                            class="w-full border p-2 rounded mb-3 focus:outline-none"
                            required
                        />
                        <div class="flex justify-between gap-3">
                            <button
                                type="button"
                                class="bg-gray-400 text-white flex-1 py-2 rounded-lg"
                                @click="cancelForm">
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="bg-secondary text-white flex-1 py-2 rounded-lg"
                                :disabled="loading">
                                {{ loading ? 'Saving...' : (form.id ? 'Update' : 'Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {ref} from 'vue'
import axios from 'axios'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import {router} from '@inertiajs/vue3'

defineProps({
    vendor_brands: Array,
})

const showForm = ref(false)
const loading = ref(false)
const form = ref({
    id: null,
    name: '',
})

async function saveBrand() {
    try {
        loading.value = true
        let res

        if (form.value.id) {
            res = await axios.patch(`/vendor/brand/${form.value.id}/update`, {
                name: form.value.name,
            })
        } else {
            res = await axios.post('/vendor/brand/create', {
                name: form.value.name,
            })
        }

        alert(res.data.message)
        router.visit(window.location.href, {preserveScroll: true})
        resetForm()
    } catch (err) {
        alert(err.response?.data?.message || 'Something went wrong')
        console.error(err)
    } finally {
        loading.value = false
    }
}

async function deleteBrand(id) {
    try {
        if (!confirm('Are you sure you want to delete this brand?')) return
        await axios.delete(`/vendor/brand/${id}/delete`)
        alert('Brand deleted successfully')
        router.visit(window.location.href, {preserveScroll: true})
    } catch (err) {
        console.error(err)
        alert('Failed to delete brand')
    }
}

function editBrand(brand) {
    form.value = {id: brand.id, name: brand.name}
    showForm.value = true
}

function cancelForm() {
    resetForm()
    showForm.value = false
}

function resetForm() {
    form.value = {id: null, name: ''}
    showForm.value = false
}
</script>
