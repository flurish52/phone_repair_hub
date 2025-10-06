<template>
    <AuthenticatedLayout>
        <AddEditJob
            :show="showAddRepairModal"
            @close="showAddRepairModal = false"
        />

        <div class="flex min-h-screen bg-primary justify-center">
            <main class="flex-1 md:ml-56 flex flex-col items-center relative">
                <transition name="fade">
                    <div
                        class="fixed top-20 md:top-32 left-1/2 transform -translate-x-1/2 bg-secondary/10 text-secondary text-sm md:text-base px-4 py-2 rounded-lg shadow-md z-40"
                    >
                        💰 Pricing feature under development. Stay tuned for updates....
                    </div>
                </transition>

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
            </main>
        </div>
    </AuthenticatedLayout>
</template>
    <script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AddEditJob from "@/Components/AddEditJob.vue";
import {ref, onMounted, watch} from 'vue'
import {Link} from "@inertiajs/vue3";
let showAddRepairModal = ref(false)

const openShowAddRepairModal =()=>{
    showAddRepairModal.value  = true
};
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
