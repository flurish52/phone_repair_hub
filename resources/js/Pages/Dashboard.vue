<template>
    <AuthenticatedLayout>
        <AddEditJob
            :show="showAddRepairModal"
            @close="showAddRepairModal = false"
            :repair="repairToEdit"
        />
        <ViewRepair
            :show="showViewRepairModal"
            :repair="repairToView"
            @close="showViewRepairModal = false"
            @delete="deleteRepair"
            @edit="editRepair"
        />
        <RepairStatusUpdate
            :show="showStatusModal"
            :repair="selectedRepair"
            @close="showStatusModal = false"
        />

        <div class="flex min-h-screen bg-[#fdfdf7]">
            <!-- Main content -->
            <main class="flex-1 md:ml-56 p-1 md:p-6 lg:p-8 pb-16 md:pb-4">
                <div class="max-w-7xl mx-auto">
                    <!-- Header Section -->
                    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-[#536b7b]">
                                Repairs
                            </h1>
                            <p class="text-sm text-gray-600 mt-1">Manage and track all your repair jobs</p>
                        </div>
                        <button
                            @click="showAddRepairModal = !showAddRepairModal"
                            class="hidden md:flex items-center gap-2 px-6 py-2.5 bg-[#536b7b] text-[#fdfdf7] font-semibold rounded-lg shadow-md hover:bg-[#3a4d5a] hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Repair
                        </button>
                    </div>

                    <!-- Filters Section -->
                    <div class="mb-6">
                        <Filters
                            :current-status="filters.status"
                            :current-sort="filters.sort"
                            @update:status="(val) => filters.status = val"
                            @update:sort="(val) => filters.sort = val"
                            @update:search="(val) => filters.search = val"
                        />
                    </div>

                    <!-- Table Section -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                        <!-- Empty State -->
                        <div v-if="repairsToDisplay.length === 0" class="flex flex-col items-center justify-center py-16 px-4">
                            <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-700 mb-1">No repairs found</h3>
                            <p class="text-sm text-gray-500">Try adjusting your filters or add a new repair</p>
                        </div>

                        <!-- Table -->
                        <div v-else class="overflow-x-auto px-2">
                            <table class="w-full">
                                <!-- Table Head -->
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                                <tr>
                                    <th class="px-1 lg:px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">S/N</th>
                                    <th class="px-1 lg:px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Client Name</th>
                                    <th class="px-1 lg:px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Device</th>
                                    <th class="px-1 lg:px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                    <th class="hidden md:table-cell px-3 lg:px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Issue</th>
                                    <th class="hidden lg:table-cell px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pickup PIN</th>
                                    <th class="hidden lg:table-cell px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Entry Date</th>
                                    <th class="px-1 lg:px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Action</th>
                                </tr>
                                </thead>

                                <!-- Table Body -->
                                <tbody class="divide-y divide-gray-100">
                                <tr
                                    v-for="(repair, index) in repairsToDisplay"
                                    :key="repair.id"
                                    class="hover:bg-gray-100 rounded-md transition-colors duration-150 group"
                                >
                                    <td class="px-1 lg:px-4 py-4 text-sm text-gray-700 font-medium">
                                        {{ index + 1 }}
                                    </td>
                                    <td class="px-1 lg:px-4 py-4 text-sm text-gray-800 font-medium">
                                        {{ repair.client_name }}
                                    </td>
                                    <td class="px-1 lg:px-4 py-4 text-sm text-gray-700">
                                        {{ repair.device }}
                                    </td>
                                    <td class="px-1 lg:px-4 py-4 text-sm">
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full"
                                                :class="{
                                                    'bg-yellow-100 text-yellow-800 ring-1 ring-yellow-200': repair.status === 'Pending',
                                                    'bg-green-100 text-green-800 ring-1 ring-green-200': repair.status === 'Ready for Pickup',
                                                    'bg-blue-100 text-blue-800 ring-1 ring-blue-200': repair.status === 'Picked Up'
                                                }"
                                            >
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full mr-1.5"
                                                    :class="{
                                                        'bg-yellow-500': repair.status === 'Pending',
                                                        'bg-green-500': repair.status === 'Ready for Pickup',
                                                        'bg-blue-500': repair.status === 'Picked Up'
                                                    }"
                                                ></span>
                                                {{ repair.status }}
                                            </span>
                                    </td>
                                    <td class="hidden md:table-cell px-1 lg:px-6 py-4 text-sm text-gray-600 max-w-xs truncate" :title="repair.issue">
                                        {{ repair.issue }}
                                    </td>
                                    <td class="hidden lg:table-cell px-1 py-4 text-sm text-gray-600 font-mono">
                                        {{ '*'.repeat(repair.pickup_pin.length - 2) + repair.pickup_pin.slice(-2) }}
                                    </td>
                                    <td class="hidden lg:table-cell px-1 py-4 text-sm text-gray-600 whitespace-nowrap">
                                        {{ new Date(repair.created_at).toLocaleString('en-GB', {
                                        day: '2-digit',
                                        month: 'short',
                                        year: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit',
                                        hour12: true
                                    }) }}
                                    </td>
                                    <td class="px-1 flex flex-col justify-between lg:px-4 py-4 text-sm">
                                        <button
                                            @click="viewRepair(repair)"
                                            class="py-1 hover:bg-gray-200 px-1 text-blue-500 hover:text-blue-600 inline-flex items-center gap-1.5 text-[#536b7b] hover:text-[#3a4d5a] font-medium transition-colors duration-150 group-hover:underline"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            View
                                        </button>
                                        <button
                                            @click="updateStatus(repair)"
                                            class="py-1 hover:bg-gray-200 px-1 inline-flex items-center gap-1.5 text-green-500 hover:text-green-600 font-medium transition-colors duration-150 group-hover:underline"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4h2m-1 0v16m4-10h4m-4 0H5" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 3.487a2.121 2.121 0 013 3L8.25 18.1 3 19l.9-5.25L16.862 3.487z" />
                                            </svg>
                                            Update
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Results count -->
                    <div v-if="repairsToDisplay.length > 0" class="mt-4 text-sm text-gray-600 text-center md:text-left">
                        Showing <span class="font-semibold text-gray-800">{{ repairsToDisplay.length }}</span> repair{{ repairsToDisplay.length !== 1 ? 's' : '' }}
                    </div>
                </div>
            </main>
        </div>

        <!-- Mobile bottom navigation -->
        <div class="fixed bottom-0 left-0 right-0 md:hidden bg-white border-t border-gray-200 shadow-2xl z-50">
            <div class="flex justify-around items-center px-4 py-3 max-w-lg mx-auto">
                <Link
                    href="/dashboard"
                    class="flex flex-col items-center gap-1 text-gray-600 hover:text-[#536b7b] transition-colors duration-200 flex-1"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-xs font-medium">Home</span>
                </Link>

                <button
                    @click="openShowAddRepairModal"
                    class="flex items-center justify-center -mt-8 w-14 h-14 bg-gradient-to-br from-[#536b7b] to-[#3a4d5a] text-white rounded-full shadow-xl hover:shadow-2xl transition-all duration-200 hover:scale-105 active:scale-95"
                >
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>

                <Link
                    href="/prices"
                    class="flex flex-col items-center gap-1 text-gray-600 hover:text-[#536b7b] transition-colors duration-200 flex-1"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-xs font-medium">Accessories</span>
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AddEditJob from "@/Components/AddEditJob.vue";
import { ref, watch } from 'vue'
import axios from 'axios'
import Filters from "@/Components/Filters.vue";
import ViewRepair from "@/Components/ViewRepair.vue";
import { Link, router } from "@inertiajs/vue3";
import RepairStatusUpdate from "@/Components/RepairStatusUpdate.vue";

const props = defineProps({
    repairs: Array,
})

const showViewRepairModal = ref(false);
const repairToView = ref({});
const showAddRepairModal = ref(false)
const repairToEdit = ref({})
const repairsToDisplay = ref(props.repairs)
let showStatusModal = ref(false)
let selectedRepair = ref({})

const viewRepair = (repair) => {
    repairToView.value = repair
    showViewRepairModal.value = true
}
const updateStatus = (repair) => {
    showStatusModal.value = true
    selectedRepair.value = repair
};

const deleteRepair = (repair) => {
    axios.delete(`/repair/delete/${repair.id}`)
        .then(res => {
            if (res.status === 200) {
                router.visit(window.location.href, { preserveScroll: true })
            }
        })
};

const editRepair = (repair) => {
    repairToEdit.value = repair
    showAddRepairModal.value = true
};

const openShowAddRepairModal = () => {
    repairToEdit.value = {}
    showAddRepairModal.value = true
};

const filters = ref({
    status: 'all',
    sort: 'newest',
    search: ''
})

// Fetch jobs with both filters applied
const fetchJobs = async () => {
    try {
        const response = await axios.get('/fetch/repairs', {
            params: {
                status: filters.value.status,
                sort: filters.value.sort,
                search: filters.value.search
            }
        })
        repairsToDisplay.value = response.data
    } catch (error) {
        console.error('Error fetching jobs:', error)
    }
}

watch(
    () => [filters.value.status, filters.value.sort, filters.value.search],
    fetchJobs
)
</script>
