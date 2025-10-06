<script setup>
import { ref } from 'vue'
const props = defineProps({
    currentStatus: { type: String, default: 'all' },
    currentSort: { type: String, default: 'newest' }
})
const emit = defineEmits(['update:status', 'update:sort', 'update:search', ])
const searchQuery = ref('')
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

const searchRepair = () => {
    emit('update:search', searchQuery)
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

        <div class="flex items-center justify-center mb-4">
            <div class="relative w-full  ">
                <input
                    v-model="searchQuery"
                    @keyup="searchRepair"
                    type="search"
                    placeholder="Search by client, device, or staff..."
                    class="w-full pr-12 pl-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-indigo-100 hover:border-gray-400 transition"
                />
    <button
        @click="searchRepair"
        class="absolute inset-y-0 right-0 flex items-center bg-gray-300 w-10 rounded-r-md text-gray-400">
      🔍
    </button>
            </div>
        </div>



        <!-- Status Filters -->
        <div class="flex justify-between gap-2 h-fit flex-wrap">
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
