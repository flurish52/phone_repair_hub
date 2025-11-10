<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import Navigation from "@/Components/Mobile/Navigation.vue";
</script>

<template>
    <div
    >
            <slot />

        <footer class=" bg-secondary text-primary py-3  md:mb-1"
                :class="$page.props.auth && $page.props.auth.user? 'pb-24' : ''">
            <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
                <p class="text-sm">&copy; {{ new Date().getFullYear() }} Phixobel</p>
                <nav class="flex gap-4 mt-3 md:mt-0">
                    <a href="#" class="text-primary hover:underline">Privacy</a>
                    <a href="#" class="text-primary hover:underline">Terms</a>
                    <a href="#" class="text-primary hover:underline">Contact</a>
                </nav>
            </div>
        </footer>

        <Navigation v-if="$page.props.auth && $page.props.auth.user" />
    </div>

</template>
