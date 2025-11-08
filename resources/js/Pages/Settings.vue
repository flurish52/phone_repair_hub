<template>
    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto bg-primary rounded-2xl shadow p-6 mt-6">
            <h2 class="text-2xl font-semibold mb-4 text-secondary">Update Profile </h2>
            <div class="bg-yellow-100 text-yellow-800 p-3 rounded mb-4 text-sm">
               Note: Changing your name will also change your profile URL.
            </div>

            <form @submit.prevent="updateProfile" class="space-y-4 mb-12">
                <div>
                    <label class="block text-sm font-medium text-secondary mb-1">Name</label>
                    <input v-model="form.name" type="text"
                           class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-secondary/40"/>
                </div>

                <div>
                    <label class="block text-sm font-medium text-secondary mb-1">Email</label>
                    <input v-model="form.email" type="email"
                           class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-secondary/40"/>
                </div>

                <div>
                    <label class="block text-sm font-medium text-secondary mb-1">Phone</label>
                    <input v-model="form.phone" type="text"
                           class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-secondary/40"/>
                </div>

                <div>
                    <label class="block text-sm font-medium text-secondary mb-1">Address</label>
                    <textarea v-model="form.address"
                              class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-secondary/40"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-secondary mb-1">Business logo</label>
                    <input type="file" @change="handleAvatar" class="w-full border rounded px-3 py-2 bg-white"/>
                    <div v-if="preview" class="mt-2">
                        <img :src="preview" alt="Avatar preview" class="h-16 w-16 rounded-full object-cover"/>
                    </div>
                </div>

<!--                <div v-if="form.is_active === false" class="flex items-center space-x-2">-->
<!--                    <input v-model="form.is_active" type="checkbox" id="active" class="w-4 h-4"/>-->
<!--                    <label for="active" class="text-sm text-secondary">Activate account</label>-->
<!--                </div>-->
<!--                    <p v-if="form.is_active === false" class="text-sm text-gray-600 text-red-600 italic">-->
<!--                        Your account is in active.-->
<!--                    </p>-->


                <div class="flex justify-end">
                    <button type="submit" :disabled="form.processing"
                            class="px-6 py-2 bg-secondary text-white rounded hover:bg-secondary/90">
                        {{ form.processing ? 'Updating...' : 'Update Profile' }}
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {ref} from 'vue'
import {useForm} from '@inertiajs/vue3'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const user = defineProps({user: Object})

const form = useForm({
    name: user.user.name || '',
    email: user.user.email || '',
    phone: user.user.phone || '',
    address: user.user.address || '',
    avatar: null,
    is_active: user.user.is_active || false,
})

const preview = ref(user.user.avatar ? `/storage/${user.user.avatar}` : null)

function handleAvatar(e) {
    const file = e.target.files[0]
    if (file) {
        form.avatar = file
        preview.value = URL.createObjectURL(file)
    }
}

function updateProfile() {
    form.post('/vendor/profile/update', {
        forceFormData: true,
        onSuccess: () => {
            alert('Profile updated successfully')
        },
    })
}
</script>
