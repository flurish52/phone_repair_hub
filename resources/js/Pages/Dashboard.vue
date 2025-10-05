<template>
    <AuthenticatedLayout>
        <AddEditJob :show="showModalAddJobModal"
                    @close="showModalAddJobModal = false"
                    :job="currentJob"/>
        <div class="flex min-h-screen bg-primary justify-center">

            <!-- Main content -->
            <main class="flex-1 md:ml-56 flex flex-col items-center  relative">
                <!-- Mobile content placeholder -->

                    <section class="w-full  flex flex-col ">
                        <div class="mb-6 flex justify-between">
                            <h1 class="text-2xl font-bold text-secondary border-b border-gray-200 pb-2">
                                Repairs
                            </h1>
                            <button
                                @click="showModalAddJobModal = !showModalAddJobModal"
                                class="hidden md:block px-4 py-2 bg-secondary text-primary font-semibold rounded-lg shadow hover:bg-primary hover:text-secondary transition-colors">
                                Add Repair
                            </button>
                        </div>

                        <!-- Filters -->
                        <div class="mb-4 ">
                            <Filters
                                :current-status="filters.status"
                                :current-sort="filters.sort"
                                @update:status="(val) => emit('update:status', val)"
                                @update:sort="(val) => emit('update:sort', val)"
                            />
                        </div>

                        <!-- Table -->
                        <div class=" flex items-center justify-center bg-white rounded-lg shadow">
                            <table class="min-w-full border-collapse">
                                <!-- Table Head -->
                                <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-1 md:px-4 py-2 text-left text-sm font-medium text-gray-600">Client Name</th>
                                    <th class="px-1 md:px-4 py-2 text-left text-sm font-medium text-gray-600">Device</th>
                                    <th class="px-1 md:px-4 py-2 text-left text-sm font-medium text-gray-600">Status</th>
                                    <!-- Desktop only -->
                                    <th class="hidden md:table-cell px-1 py-2 text-left text-sm font-medium text-gray-600">Issue</th>
                                    <th class="hidden md:table-cell px-1 py-2 text-left text-sm font-medium text-gray-600">Pickup PIN</th>
                                    <th class="hidden md:table-cell px-1 py-2 text-left text-sm font-medium text-gray-600">Entry Date</th>
                                    <th class="px-1 md:px-4 py-2 text-left text-sm font-medium text-gray-600">Details</th>
                                </tr>
                                </thead>

                                <!-- Table Body -->
                                <tbody>
                                <tr
                                    v-for="repair in repairs"
                                    :key="repair.id"
                                    class="border-b hover:bg-gray-50 transition"
                                >
                                    <td class="px-1 md:px-4 py-2 text-sm text-gray-800">{{ repair.clientName }}</td>
                                    <td class="px-1 md:px-4 py-2 text-sm text-gray-800">{{ repair.device }}</td>
                                    <td class="px-1 md:px-4 py-2 text-sm">
              <span
                  class="px-2 py-1 text-xs font-medium rounded"
                  :class="{
                  'bg-yellow-100 text-yellow-700': repair.status === 'Pending',
                  'bg-green-100 text-green-700': repair.status === 'Ready for Pickup',
                  'bg-blue-100 text-blue-700': repair.status === 'Picked Up'
                }"
              >
                {{ repair.status }}
              </span>
                                    </td>

                                    <!-- Desktop only columns -->
                                    <td class="hidden md:table-cell px-1 md:px-4 py-2 text-sm text-gray-600">{{ repair.issue }}</td>
                                    <td class="hidden md:table-cell px-1 md:px-4 py-2 text-sm text-gray-600">{{ repair.pickupPin }}</td>
                                    <td class="hidden md:table-cell px-1 md:px-4 py-2 text-sm text-gray-600">{{ repair.createdAt }}</td>
                                    <td class="table-cell px-1 md:px-4 py-2 text-sm text-gray-600">View</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>


                <!-- Mobile bottom navigation -->
                <div
                    class="fixed bottom-0 h-20 left-0 shadow-md border-t-2 right-0 md:hidden bg-primary border-t border-gray-200 flex justify-around items-center py-4">
                    <Link
                        href="/dashboard"
                        class="flex flex-col items-center text-secondary hover:text-primary transition-colors duration-300">
                        <span class="text-2xl">🏠</span>
                        <span class="text-xs mt-1">Home</span>
                    </Link>

                    <button
                        @click="showModalAddJobModal = !showModalAddJobModal"
                        class="bg-secondary text-primary rounded-full p-4 hover:bg-primary hover:text-secondary transition-colors duration-300 text-xl">
                        ➕
                    </button>

                    <button
                        class="flex flex-col items-center text-secondary hover:text-primary transition-colors duration-300">
                        <span class="text-2xl">💰</span>
                        <span class="text-xs mt-1">Prices</span>
                    </button>
                </div>
            </main>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AddEditJob from "@/Components/AddEditJob.vue";
import {ref, onMounted} from 'vue'
import axios from 'axios'
import Filters from "@/Components/Filters.vue";

const currentJob = ref({});
let showModalAddJobModal = ref(false)


const filters = ref({
    status: 'all',
    sort: 'newest'
})

const jobs = ref([])

// Fetch jobs with both filters applied
const fetchJobs = async () => {
    try {
        const response = await axios.get('/api/jobs', {
            params: {
                status: filters.value.status,
                sort: filters.value.sort
            }
        })
        jobs.value = response.data
    } catch (error) {
        console.error('Error fetching jobs:', error)
    }
}

const fetchJobsByStatus = (status) => {
    filters.value.status = status
    fetchJobs()
}

const fetchJobsBySort = (sort) => {
    filters.value.sort = sort
    fetchJobs()
}

onMounted(() => {
    fetchJobs()
})

const repairs = [
    {
        id: 1,
        clientName: "John Doe",
        device: "iPhone 12",
        issue: "Screen replacement",
        pickupPin: "4321",
        status: "Pending",
        createdAt: "2025-10-01",
    },
    {
        id: 2,
        clientName: "Mary Jane",
        device: "Samsung S22",
        issue: "Battery problem",
        pickupPin: "8765",
        status: "Ready for Pickup",
        createdAt: "2025-10-02",
    }
];




</script>

<style>
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
