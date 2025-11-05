<template>
    <div class="bg-white shadow rounded-lg py-4 w-full md:w-1/3">
        <label class="block text-sm font-medium text-gray-700 mb-2">Your Store Link</label>
        <div class="flex items-center gap-2">
            <input
                type="text"
                :value="storeLink"
                readonly
                class="border text-primary-dark bg-primary-light border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-secondary"
            />
            <button
                @click="copyToClipboard"
                class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary-dark"
            >
                {{ copied ? 'Copied' : 'Copy' }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
    storeSlug: {
        type: String,
        required: true
    }
})

const copied = ref(false)

const storeLink = computed(() => `${window.location.origin}/vendor/${props.storeSlug}`)

const copyToClipboard = async () => {
    try {
        if (navigator?.clipboard?.writeText) {
            await navigator.clipboard.writeText(storeLink.value)
        } else {
            const el = document.createElement('textarea')
            el.value = storeLink.value
            document.body.appendChild(el)
            el.select()
            document.execCommand('copy')
            document.body.removeChild(el)
        }
        copied.value = true
        setTimeout(() => (copied.value = false), 2000)
    } catch (err) {
        console.error('Copy failed', err)
    }
}
</script>


<style scoped>
.bg-secondary {
    background-color: #1f2937;
}
.bg-secondary-dark {
    background-color: #111827;
}
</style>
