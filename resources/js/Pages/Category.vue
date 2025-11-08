<template>
    <AuthenticatedLayout>
        <div class="p-6 grid md:grid-cols-2 gap-6">
            <!-- Categories List -->
            <div class="bg-primary rounded-2xl shadow p-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-secondary text-lg font-semibold">Categories</h2>
                    <button
                        class="md:hidden bg-secondary text-white px-4 py-2 rounded-lg"
                        @click="showForm = true">
                        Add New
                    </button>
                </div>

                <!-- Hierarchical list -->
                <ul>
                    <CategoryItem
                        v-for="category in vendor_cats.filter(c => !c.parent_id)"
                        :key="category.id"
                        :category="category"
                        :allCategories="vendor_cats"
                        @edit="editCategory"
                        @delete="deleteCategory"
                    />
                </ul>
            </div>

            <!-- Desktop form -->
            <div class="bg-primary rounded-2xl shadow p-4 hidden md:block">
                <h2 class="text-secondary text-lg font-semibold mb-4">
                    {{ form.id ? 'Edit Category' : 'Add New Category' }}
                </h2>
                <form @submit.prevent="saveCategory">
                    <input
                        v-model="form.name"
                        type="text"
                        placeholder="e.g Phones & Tablets"
                        class="w-full border p-2 rounded mb-3 focus:outline-none"
                        required
                    />
                    <select
                        v-model="form.parent_id"
                        class="w-full border p-2 rounded mb-3 focus:outline-none">
                        <option value="">Select Parent</option>
                        <option
                            v-for="category in vendor_cats"
                            :key="category.id"
                            :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                    <button
                        type="submit"
                        class="bg-secondary text-white w-full py-2 rounded-lg"
                        :disabled="loading">
                        {{ loading ? 'Saving...' : (form.id ? 'Update' : 'Save') }}
                    </button>
                </form>
            </div>

            <!-- Mobile modal -->
            <div
                v-if="showForm"
                class="fixed inset-0 bg-black/50 flex items-center justify-center md:hidden">
                <div class="bg-primary p-6 rounded-xl w-11/12 max-w-sm">
                    <h2 class="text-secondary text-lg font-semibold mb-4">
                        {{ form.id ? 'Edit Category' : 'Add New Category' }}
                    </h2>
                    <form @submit.prevent="saveCategory">
                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="e.g Phones and tablets"
                            class="w-full border p-2 rounded mb-3 focus:outline-none"
                            required
                        />
                        <select
                            v-model="form.parent_id"
                            class="w-full border p-2 rounded mb-3 focus:outline-none">
                            <option value="">Select Parent</option>
                            <option
                                v-for="category in vendor_cats"
                                :key="category.id"
                                :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
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
import { ref } from 'vue'
import axios from 'axios'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import CategoryItem from '@/Components/Category/CategoryItem.vue'
import { router } from '@inertiajs/vue3'

defineProps({
    vendor_cats: Array,
})

const showForm = ref(false)
const loading = ref(false)
const form = ref({
    id: null,
    name: '',
    parent_id: '',
})

async function saveCategory() {
    try {
        loading.value = true
        let res
        if (form.value.id) {
            res = await axios.patch(`/vendor/category/${form.value.id}/update`, {
                name: form.value.name,
                parent_id: form.value.parent_id || null,
            })
        } else {
            res = await axios.post('/vendor/categories/create', {
                name: form.value.name,
                parent_id: form.value.parent_id || null,
            })
        }

        alert(res.data.message)
        resetForm()
        router.visit(window.location.href, { preserveScroll: true })
    } catch (err) {
        if (err.response?.data?.message) {
            alert(err.response.data.message)
        } else {
            alert('Something went wrong')
        }
        console.error(err)
    } finally {
        loading.value = false
    }
}

async function deleteCategory(id) {
    try {
        if (confirm('Are you sure you want to delete this category?')) {
            const res = await axios.delete(`/vendor/category/${id}/delete`)
            alert(res.data.message)
            router.visit(window.location.href, { preserveScroll: true })
        }
    } catch (err) {
        alert('Unable to delete category')
        console.error(err)
    }
}

function editCategory(category) {
    form.value = {
        id: category.id,
        name: category.name,
        parent_id: category.parent_id || '',
    }
    showForm.value = true
}

function cancelForm() {
    showForm.value = false
    resetForm()
}

function resetForm() {
    form.value = { id: null, name: '', parent_id: '' }
}
</script>
