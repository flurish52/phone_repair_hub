<template>
    <transition name="fade">
        <div
            v-if="show"
            @click.self="closeModal"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
        >
            <div
                class="bg-primary rounded-lg shadow-lg w-11/12 max-w-md max-h-[90vh] flex flex-col p-6 relative"
            >
                <div class="flex justify-between items-center mb-4 flex-shrink-0">
                    <h2 class="text-xl font-bold text-secondary">
                        {{ isEdit ? 'Edit Repair' : 'Add Repair' }}
                    </h2>
                    <button @click="closeModal" class="text-secondary hover:text-primary">&times;</button>
                </div>

                <!-- Scrollable form -->
                <div class="space-y-4 overflow-y-auto pr-2 flex-1">
                    <div>
                        <label class="block text-secondary mb-1">Client Name *</label>
                        <input
                            v-model="clientName"
                            type="text"
                            class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-secondary"
                        />
                        <p v-if="errors.clientName" class="text-red-500 text-sm mt-1">{{ errors.clientName }}</p>
                    </div>

                    <div>
                        <label class="block text-secondary mb-1">Client Phone</label>
                        <input
                            v-model="clientPhone"
                            type="text"
                            class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-secondary"
                        />
                        <p v-if="errors.clientPhone" class="text-red-500 text-sm mt-1">{{ errors.clientPhone }}</p>
                    </div>

                    <div>
                        <label class="block text-secondary mb-1">Device *</label>
                        <input
                            v-model="device"
                            type="text"
                            placeholder="e.g. iPhone 13"
                            class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-secondary"
                        />
                        <p v-if="errors.device" class="text-red-500 text-sm mt-1">{{ errors.device }}</p>
                    </div>

                    <div>
                        <label class="block text-secondary mb-1">Issue *</label>
                        <textarea
                            v-model="issue"
                            class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-secondary"
                            rows="2"
                        ></textarea>
                        <p v-if="errors.issue" class="text-red-500 text-sm mt-1">{{ errors.issue }}</p>
                    </div>
                    <div>
                        <label class="block text-secondary mb-1">Pickup pin *</label>
                        <input
                            v-model="pickup_pin"
                            type="text"
                            placeholder="'1234' or 'Joe smith'"
                            class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-secondary"
                        />
                        <p v-if="errors.pickup_pin" class="text-red-500 text-sm mt-1">{{ errors.pickup_pin }}</p>
                    </div>

                    <div>
                        <label class="block text-secondary mb-1">Notes</label>
                        <textarea
                            v-model="notes"
                            class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-secondary"
                            rows="2"
                        ></textarea>
                    </div>

                    <div>
                        <label class="block text-secondary mb-1">Staff</label>
                        <input
                            v-model="staff"
                            type="text"
                            class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-secondary"
                        />
                    </div>

                    <div>
                        <label class="block text-secondary mb-1">Cost</label>
                        <input
                            v-model="cost"
                            type="number"
                            step="0.01"
                            class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-secondary"
                        />
                    </div>

                    <div>
                        <label class="block text-secondary mb-1">Status</label>
                        <select
                            v-model="status"
                            class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-secondary"
                        >
                            <option value="pending">Pending</option>
                            <option value="ready">Ready</option>
                            <option value="picked">Picked</option>
                        </select>
                    </div>



                    <div>
                        <label class="block text-secondary mb-1">Upload Images</label>
                        <input
                            type="file"
                            multiple
                            @change="handleFiles"
                            class="w-full"
                        />
                        <div class="mt-2 flex flex-wrap gap-2">
                            <div class="flex flex-wrap gap-2">
                                <!-- Images from DB -->
                                <div
                                    v-for="(img, index) in imagePreviews"
                                    :key="index"
                                    class="relative w-20 h-20 rounded overflow-hidden border border-secondary/20"
                                >
                                    <img :src="img.src" class="w-full h-full object-cover" />
                                    <button
                                        @click="removeImage(index)"
                                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs"
                                    >×</button>
                                </div>
                            </div>

                        </div>
                            </div>

                </div>

                <!-- Buttons -->
                <div class="mt-6 flex justify-end space-x-3 flex-shrink-0">
                    <button
                        @click="closeModal"
                        class="px-4 py-2 rounded bg-gray-300 text-secondary hover:bg-secondary hover:text-primary"
                    >
                        Cancel
                    </button>
                    <button
                        @click="saveJob"
                        :disabled="isSaving"
                        class="px-4 py-2 rounded bg-secondary text-primary hover:bg-primary hover:text-secondary flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <svg
                            v-if="isSaving"
                            class="animate-spin h-4 w-4 text-primary"
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
                        <span>{{ isSaving ? 'Saving...' : 'Save' }}</span>
                    </button>

                </div>
            </div>
        </div>
    </transition>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
import axios from 'axios'
import { router } from "@inertiajs/vue3"

const props = defineProps({
    show: { type: Boolean, required: true },
    repair: { type: Object, default: () => ({}) },
})

const emit = defineEmits(['close', 'saved'])

const clientName = ref('')
const clientPhone = ref('')
const device = ref('')
const issue = ref('')
const notes = ref('')
const staff = ref('')
const cost = ref('')
const pickup_pin = ref('')
const status = ref('pending')

let  isSaving = ref(false)
// Store both existing image URLs and newly uploaded files
const existingImages = ref([]) // URLs from DB
const newImages = ref([])      // File objects
const imagePreviews = ref([])  // preview URLs for both

const errors = ref({})

const isEdit = computed(() => props.repair && Object.keys(props.repair).length > 0)

// Generate previews combining existing URLs + new files
const generatePreviews = () => {
    imagePreviews.value = [
        ...existingImages.value.map(img => ({ src: `/storage/${img}`, isDb: true })),
        ...newImages.value.map(file => ({ src: URL.createObjectURL(file), isDb: false }))
    ]
}


watch(
    () => props.repair,
    repair => {
        clientName.value = repair?.client_name ?? ''
        clientPhone.value = repair?.client_phone ?? ''
        device.value = repair?.device ?? ''
        issue.value = repair?.issue ?? ''
        notes.value = repair?.notes ?? ''
        staff.value = repair?.staff ?? ''
        cost.value = repair?.cost ?? ''
        pickup_pin.value = repair?.pickup_pin ?? ''
        status.value = repair?.status ?? 'pending'

        // Load existing images from DB
        existingImages.value = repair?.images ? JSON.parse(repair.images) : []
        generatePreviews()
    },
    { immediate: true }
)


// Handle file selection
import imageCompression from 'browser-image-compression'

const handleFiles = async (e) => {
    isSaving.value = true
    const files = Array.from(e.target.files)
    const compressed = []

    for (const file of files) {
        const options = {
            maxSizeMB: 2,
            maxWidthOrHeight: 1200,
            useWebWorker: true,
        }
        const compressedFile = await imageCompression(file, options)
        compressed.push(compressedFile)
    }

    newImages.value.push(...compressed)
    generatePreviews() // your existing function to show previews
    isSaving.value = false
}


// Remove image from previews (works for both existing URLs and new files)
const removeImage = (index) => {
    if (index < existingImages.value.length) {
        existingImages.value.splice(index, 1)
    } else {
        const fileIndex = index - existingImages.value.length
        newImages.value.splice(fileIndex, 1)
    }
    generatePreviews()
}

const validate = () => {
    const errs = {}
    if (!clientName.value.trim()) errs.clientName = 'Client name is required'
    // if (!clientPhone.value.trim()) errs.clientPhone = 'Client phone is required'
    if (!device.value.trim()) errs.device = 'Device is required'
    if (!issue.value.trim()) errs.issue = 'Issue is required'
    if (!pickup_pin.value.trim()) errs.pickup_pin = 'Pickup pin is required'
    errors.value = errs
    return Object.keys(errs).length === 0
}

const saveJob = async () => {
    if (!validate()) return

    const formData = new FormData()
    formData.append('client_name', clientName.value)
    formData.append('client_phone', clientPhone.value)
    formData.append('device', device.value)
    formData.append('issue', issue.value)
    formData.append('notes', notes.value)
    formData.append('staff', staff.value)
    formData.append('cost', cost.value)
    formData.append('pickup_pin', pickup_pin.value)
    formData.append('status', status.value)
    // append existing images as JSON
    formData.append('existing_images', JSON.stringify(existingImages.value))
    // append new files
    newImages.value.forEach(file => formData.append('images[]', file))
    isSaving.value = true
    try {
        if (isEdit.value) {
            await axios.post(`/repair/update/${props.repair.id}`, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })
        } else {
            await axios.post('/repair/create', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })
        }
        emit('saved')
        emit('close')
        router.visit(window.location.href, { preserveScroll: true })
    } catch (err) {
        console.error(err)
    }finally {
        isSaving.value = false
    }
}

const closeModal = () => {
    errors.value = {}
    emit('close')
    router.visit(window.location.href, { preserveScroll: true })
}
</script>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
.bg-primary {
    background-color: #fdfdf7;
}
.bg-secondary {
    background-color: #536b7b;
}
.text-primary {
    color: #fdfdf7;
}
.text-secondary {
    color: #536b7b;
}
</style>

