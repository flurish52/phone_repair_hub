<script setup>
import { ref, watch, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
    show: { type: Boolean, required: true },
    job: { type: Object, default: () => ({}) },
});

const emit = defineEmits(['close', 'saved']);

const deviceType = ref('');
const issueNotes = ref('');
const pickupPin = ref('');
const errors = ref({});

// Determine if editing or creating
const isEdit = computed(() => props.job && Object.keys(props.job).length > 0);

// Initialize form safely
watch(
    () => props.job,
    (newJob) => {
        deviceType.value = newJob?.deviceType ?? '';
        issueNotes.value = newJob?.issueNotes ?? '';
        pickupPin.value = newJob?.pickupPin ?? '';
        errors.value = {};
    },
    { immediate: true }
);

const validate = () => {
    const errs = {};
    if (!deviceType.value.trim()) errs.deviceType = 'Device Type is required';
    if (!pickupPin.value.trim()) errs.pickupPin = 'Pickup PIN is required';
    errors.value = errs;
    return Object.keys(errs).length === 0;
};

const saveJob = async () => {
    if (!validate()) return;

    const payload = {
        deviceType: deviceType.value,
        issueNotes: issueNotes.value,
        pickupPin: pickupPin.value,
    };

    try {
        if (isEdit.value) {
            // Update existing job
            await axios.post(`/update_task/update/${props.job.id}`, payload);
        } else {
            // Create new job
            await axios.post('/new_task/create', payload);
        }
        emit('saved', payload);
        emit('close');
    } catch (err) {
        console.error(err);
    }
};

const closeModal = () => emit('close');
</script>

<template>
    <transition name="fade">
        <div
            v-if="show"
            @click.self="$emit('close')"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
        >
            <div class="bg-primary rounded-lg shadow-lg w-11/12 max-w-md p-6 relative">
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-secondary">
                        {{ isEdit ? 'Edit Job' : 'Add repair' }}
                    </h2>
                    <button @click="closeModal" class="text-secondary hover:text-primary">&times;</button>
                </div>

                <!-- Form -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-secondary mb-1">Device Type *</label>
                        <input
                            type="text"
                            v-model="deviceType"
                            placeholder="e.g. iPhone 13"
                            class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-secondary"
                        />
                        <p v-if="errors.deviceType" class="text-red-500 text-sm mt-1">{{ errors.deviceType }}</p>
                    </div>

                    <div>
                        <label class="block text-secondary mb-1">Issue / Notes</label>
                        <textarea
                            v-model="issueNotes"
                            placeholder="Describe the issue (optional)"
                            class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-secondary"
                            rows="3"
                        ></textarea>
                    </div>

                    <div>
                        <label class="block text-secondary mb-1">Pickup PIN *</label>
                        <input
                            type="text"
                            v-model="pickupPin"
                            placeholder="e.g. 1234"
                            class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-secondary"
                        />
                        <p v-if="errors.pickupPin" class="text-red-500 text-sm mt-1">{{ errors.pickupPin }}</p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-6 flex justify-end space-x-3">
                    <button
                        @click="closeModal"
                        class="px-4 py-2 rounded bg-gray-300 text-secondary hover:bg-secondary hover:text-primary transition-colors"
                    >
                        Cancel
                    </button>
                    <button
                        @click="saveJob"
                        class="px-4 py-2 rounded bg-secondary text-primary hover:bg-primary hover:text-secondary transition-colors"
                    >
                        Save
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
.bg-primary { background-color: #fdfdf7; }
.bg-secondary { background-color: #536b7b; }
.text-primary { color: #fdfdf7; }
.text-secondary { color: #536b7b; }
</style>
