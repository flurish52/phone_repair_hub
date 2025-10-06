<script setup>
import { ref, defineProps, watch } from 'vue';
import ViewImageModal from "@/Components/ViewImageModal.vue";

defineProps({
    repair: {
        type: Object,
        required: true,
    },
    show: {
        type: Boolean,
        required: true,
    },
});
const showPin = ref(false)
const showImageModal = ref(false)
const currentIndex = ref(0)

const showImageModalFunc = (index) => {
    showImageModal.value = true;
    currentIndex.value = index
};

const closeModal = () => {
    emit('close');
};


function togglePin() {
    showPin.value = !showPin.value
}
const emit = defineEmits(['close', 'edit', 'delete']);
</script>
<template>
    <transition name="fade">
        <div
            v-if="show"
            @click.self="closeModal"
            class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-40 p-4"
        >
            <div
                class="bg-primary w-full max-w-2xl rounded-2xl shadow-2xl flex flex-col max-h-[80vh] overflow-hidden border border-secondary/10"
            >
                <!-- Header -->
                <div class="px-8 py-6 bg-gradient-to-r from-secondary/5 to-secondary/10 border-b border-secondary/10">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-8 bg-secondary rounded-full"></div>
                            <h2 class="text-2xl font-bold text-secondary">Repair Details</h2>
    <ViewImageModal
:images="JSON.parse(repair.images)"
                    :show="showImageModal"
                    @close="showImageModal=false"
:currentIndex="currentIndex"
    />
                        </div>
                        <button
                            @click="closeModal"
                            class="w-8 h-8 rounded-full bg-secondary/10 hover:bg-secondary/20 flex items-center justify-center transition-all duration-200 group"
                        >
                            <span class="text-secondary text-lg font-light group-hover:scale-110 transition-transform">×</span>
                        </button>
                    </div>
                </div>

                <!-- Body -->
                <div class="px-8 py-6 overflow-y-auto flex-1 space-y-6">
                    <!-- Client & Device Group -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-secondary/10">
                        <div class="space-y-1">
                            <p class="text-secondary/80 text-sm font-medium uppercase tracking-wide">Client Name</p>
                            <p class="text-secondary text-lg font-semibold">{{ repair.client_name }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-secondary/80 text-sm font-medium uppercase tracking-wide">Device</p>
                            <p class="text-secondary text-lg font-semibold">{{ repair.device }}</p>
                        </div>
                    </div>

                    <!-- Issue Section -->
                    <div class="space-y-1 pb-6 border-b border-secondary/10">
                        <p class="text-secondary/80 text-sm font-medium uppercase tracking-wide">Issue</p>
                        <p class="text-secondary text-lg leading-relaxed">{{ repair.issue }}</p>
                    </div>

                    <!-- Date & Pin Group -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-secondary/10">
                        <div class="space-y-1">
                            <p class="text-secondary/80 text-sm font-medium uppercase tracking-wide">Entry date</p>
                            <p class="text-secondary text-lg">
                                {{ new Date(repair.created_at).toLocaleString('en-GB', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: true
                            }) }}
                            </p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-secondary/80 text-sm font-medium uppercase tracking-wide">Pickup pin</p>
                            <div class="flex items-center space-x-2">
                                <p class="text-secondary text-lg">
                                    {{ showPin ? repair.pickup_pin : '*'.repeat(repair.pickup_pin.length - 2) + repair.pickup_pin.slice(-2) }}
                                </p>
                                <button @click="togglePin" class="text-blue-500 hover:underline text-sm">
                                    {{ showPin ? 'Hide' : 'Show' }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Staff & Status Group -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-secondary/10">
                        <div class="space-y-1">
                            <p class="text-secondary/80 text-sm font-medium uppercase tracking-wide">Staff</p>
                            <p class="text-secondary text-lg">{{ repair.staff || '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-secondary/80 text-sm font-medium uppercase tracking-wide">Status</p>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium capitalize"
                                :class="{
                                    'bg-green-100 text-green-800': repair.status === 'completed',
                                    'bg-yellow-100 text-yellow-800': repair.status === 'in progress',
                                    'bg-blue-100 text-blue-800': repair.status === 'pending',
                                    'bg-secondary/10 text-secondary': !['completed', 'in progress', 'pending'].includes(repair.status)
                                }"
                            >
                                {{ repair.status }}
                            </span>
                        </div>
                    </div>

                    <!-- Cost & Phone Group -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-secondary/10">
                        <div v-if="repair.cost" class="space-y-1">
                            <p class="text-secondary/80 text-sm font-medium uppercase tracking-wide">Cost</p>
                            <p class="text-secondary text-lg font-bold">₦{{ repair.cost }}</p>
                        </div>
                        <div v-if="repair.client_phone" class="space-y-1">
                            <p class="text-secondary/80 text-sm font-medium uppercase tracking-wide">Phone</p>
                            <p class="text-secondary text-lg">{{ repair.client_phone }}</p>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div v-if="repair.notes" class="space-y-3 pt-4 border-t border-secondary/10">
                        <p class="text-secondary/80 text-sm font-medium uppercase tracking-wide">Notes</p>
                        <div class="bg-secondary/5 rounded-xl p-4 border border-secondary/10">
                            <p class="text-secondary leading-relaxed">{{ repair.notes }}</p>
                        </div>
                    </div>

                    <!-- Images Section -->
                    <div v-if="JSON.parse(repair.images) && JSON.parse(repair.images).length" class="space-y-4 pt-4 border-t border-secondary/10">
                        <p class="text-secondary/80 text-sm font-medium uppercase tracking-wide">Images</p>
                        <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-5 gap-3">
                            <div
                                v-for="(img, index) in JSON.parse(repair.images)"
                                :key="index"
                                class="aspect-square rounded-xl overflow-hidden border-2 border-secondary/10 hover:border-secondary/30 transition-all duration-300 group cursor-pointer"
                            >
                                <img
                                    @click="showImageModalFunc(index)"
                                    :src="`/storage/${img}`"
                                    alt="Repair Image"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="px-8 py-6 border-t border-secondary/10 bg-primary/50 backdrop-blur-sm sticky bottom-0">
                    <div class="flex justify-end space-x-3">
                        <button
                            @click="$emit('delete', repair)"
                            class="px-6 py-3 rounded-xl bg-red-500 text-white font-semibold hover:bg-red-600 transform hover:scale-105 active:scale-95 transition-all duration-200 shadow-lg hover:shadow-xl"
                        >
                            Delete
                        </button>
                        <button
                            @click="closeModal"
                            class="px-6 py-3 rounded-xl border-2 border-secondary text-secondary font-semibold hover:bg-secondary hover:text-primary transform hover:scale-105 active:scale-95 transition-all duration-200"
                        >
                            Close
                        </button>
                        <button
                            @click="$emit('edit', repair)"
                            class="px-6 py-3 rounded-xl bg-secondary text-primary font-semibold hover:bg-secondary/90 transform hover:scale-105 active:scale-95 transition-all duration-200 shadow-lg hover:shadow-xl"
                        >
                            Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: scale(0.95);
}
</style>

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


<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: scale(0.95);
}
</style>

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
