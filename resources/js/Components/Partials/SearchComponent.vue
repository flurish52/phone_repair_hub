<template>
    <div class="relative w-full max-w-md mx-auto">
        <!-- Mobile search icon -->
        <button
            @click="toggleSearch"
            class="md:hidden p-2 text-secondary"
            aria-label="Search">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
            </svg>
        </button>
        <div
            v-if="showSearch && !isDesktop"
            class="fixed inset-0 bg-black/10 z-40"
            @click="showSearch = false">
        </div>


        <!-- Search bar -->
        <transition name="slide">
            <div
                v-if="showSearch || isDesktop"
                class="absolute md:static inset-x-0 top-0 left-0 md:bg-transparent p-4 md:p-0 z-50">
                <form @submit.prevent="search">
                    <div class="w-64 md:w-auto flex items-center border rounded-lg overflow-hidden">
                        <input
                            v-model="query"
                            @keyup="search"
                            type="text"
                            placeholder="Search products, vendors..."
                            class="flex-1 px-3 py-2 focus:outline-none"
                        />
                        <button
                            type="submit"
                            class="bg-secondary text-white px-4 py-2"
                            :disabled="loading">
                            {{ loading ? '...' : 'Search' }}
                        </button>
                    </div>
                </form>
            </div>
        </transition>

        <!-- Results dropdown -->
        <ul
            v-if="results.length && showResults"
            class="absolute w-screen md:w-auto bg-primary mt-2 rounded-lg shadow p-2 max-h-60 overflow-y-auto z-50">
            <li
                v-for="item in results"
                :key="item.id"
                class="py-2 px-3 hover:bg-secondary hover:text-white cursor-pointer" >
                <Link :href="`/products/${item.user.slug}/${item.slug}/details`">
                    {{ item.name }}
                </Link>
            </li>
        </ul>
    </div>
</template>

<script setup>
import {ref, watch, onMounted, onBeforeUnmount} from 'vue'
import axios from 'axios'
import {Link, router} from '@inertiajs/vue3'

const query = ref('')
const results = ref([])
const loading = ref(false)
const showResults = ref(false)
const showSearch = ref(false)
const isDesktop = ref(window.innerWidth >= 768)

function handleResize() {
    isDesktop.value = window.innerWidth >= 768
}

onMounted(() => window.addEventListener('resize', handleResize))
onBeforeUnmount(() => window.removeEventListener('resize', handleResize))

function toggleSearch() {
    showSearch.value = !showSearch.value
}

async function search() {
    if (!query.value.trim()) return
    loading.value = true
    showResults.value = false
    try {
        const res = await axios.get(`/search?q=${encodeURIComponent(query.value)}`)
        results.value = res.data
        showResults.value = true
    } catch (err) {
        console.error(err)
        alert('Search failed')
    } finally {
        loading.value = false
    }
}

watch(query, (val) => {
    if (!val.trim()) results.value = []
})
</script>

<style>
.slide-enter-active, .slide-leave-active {
    transition: all 0.3s ease;
}

.slide-enter-from, .slide-leave-to {
    transform: translateY(-10px);
    opacity: 0;
}
</style>
