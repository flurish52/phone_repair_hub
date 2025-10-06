<template>
    <div
        v-if="show"
        @click="$emit('close')"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50"
    >
        <div class="bg-primary rounded-xl shadow-lg w-80 p-6 relative">
            <h2 class="text-xl font-semibold text-secondary mb-4 text-center">
                Update Repair Status
            </h2>
            <div
                v-if="message"
                class="mt-4 px-4 py-3 text-green-500 rounded-lg text-center font-medium">
                {{ message }}
            </div>


            <div class="flex flex-col gap-3">
                <button
                    @click="handleUpdate('pending')"
                    class="hover:bg-gray-200 w-full py-2 rounded-lg border border-secondary text-secondary hover:bg-secondary hover:text-primary transition"
                >
                    Pending
                </button>
                <button
                    @click="handleUpdate('ready')"
                    class="hover:bg-gray-200 w-full py-2 rounded-lg border border-secondary text-secondary hover:bg-secondary hover:text-primary transition"
                >
                    Ready
                </button>
                <button
                    @click="handleUpdate('picked')"
                    class="hover:bg-gray-200 w-full py-2 rounded-lg border border-secondary text-secondary hover:bg-secondary hover:text-primary transition"
                >
                    Picked
                </button>
            </div>

            <button
                @click="$emit('close')"
                class="absolute top-2 right-3 text-secondary hover:text-gray-600"
            >
                ✕
            </button>
        </div>
    </div>
</template>

<script setup>
import {defineProps, defineEmits, ref} from 'vue'
import axios from 'axios'
import {router} from '@inertiajs/vue3'

const props = defineProps({
    show: Boolean,
    repair: Object,
})
let message = ref('')

const emit = defineEmits(['close'])

const handleUpdate = (status) => {
    axios
        .patch(`/repair/update/status/${props.repair.id}`, {status})
        .then((res) => {
            if (res.status === 200) {
                message.value = res.data.message
                    router.visit(window.location.href, {preserveScroll: true})
                    emit('close')
            }
        })
}
</script>

<style>
.bg-primary {
    background-color: #fdfdf7;
}

.text-primary {
    color: #fdfdf7;
}

.bg-secondary {
    background-color: #536b7b;
}

.text-secondary {
    color: #536b7b;
}
</style>
