<script setup>
import { ref } from 'vue'

const props = defineProps({
    currentStatus: { type: String, default: 'all' },
    currentSort: { type: String, default: 'newest' }
})

const emit = defineEmits(['update:status', 'update:sort'])

const statuses = [
    { key: 'all', label: 'All' },
    { key: 'pending', label: 'Pending' },
    { key: 'ready', label: 'Ready' },
    { key: 'picked', label: 'Picked' }
]

const sorts = [
    { key: 'newest', label: 'Newest first' },
    { key: 'oldest', label: 'Oldest first' }
]

const selectStatus = (status) => {
    emit('update:status', status)
}

const changeSort = (e) => {
    emit('update:sort', e.target.value)
}
</script>

<template>
    <div class="flex flex-col md:flex-row   md:justify-between gap-4  bg-gray-50 rounded-lg">
        <!-- Sort Select -->
        <div>
            Sort:
            <select
                :value="currentSort"
                @change="changeSort"
                class="px-4 py-2 rounded-md border border-gray-300 text-[#536b7b] focus:ring focus:ring-[#e7d4be]"
            >
                <option v-for="sort in sorts" :key="sort.key" :value="sort.key">
                    {{ sort.label }}
                </option>
            </select>
        </div>

        <!-- Status Filters -->
        <div class="flex justify-between gap-2 flex-wrap">
            <button
                v-for="status in statuses"
                :key="status.key"
                @click="selectStatus(status.key)"
                :class="[
          'px-2 flex justify-between py-2 rounded-md border transition text-sm',
          currentStatus === status.key
            ? 'bg-[#536b7b] text-white border-[#536b7b]'
            : 'bg-white text-[#536b7b] border-gray-300 hover:bg-[#e7d4be] hover:text-white'
        ]"
            >
                {{ status.label }}
            </button>
        </div>
    </div>
</template>
