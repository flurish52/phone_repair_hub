<script setup>
import {Link} from "@inertiajs/vue3";
import AuthNavBar from "@/Components/AuthNavBar.vue";
</script>

<template>
    <div class="min-h-screen bg-primary relative">
        <AuthNavBar class="fixed min-h-screen z-50" />
        <!-- Navbar -->
        <nav class="sticky top-0 flex justify-between items-center px-6 py-4 shadow-md z-40
            bg-secondary text-primary md:bg-primary md:text-secondary">

            <div class="font-bold text-lg md:ml-64">
                {{ $page.props.auth.user.name }}
            </div>
            <div>
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="bg-primary text-secondary md:bg-secondary md:text-primary px-4 py-2 rounded hover:bg-primary hover:text-secondary transition-colors duration-300"
                >
                    Logout
                </Link>
            </div>
        </nav>

        <main class="p-6">
            <slot />
        </main>


    </div>
</template>

<style>
.bg-primary { background-color: #fdfdf7; }
.bg-secondary { background-color: #536b7b; }
.text-primary { color: #fdfdf7; }
.text-secondary { color: #536b7b; }

@media (min-width: 768px) {
    .md\:bg-primary { background-color: #fdfdf7; }
    .md\:bg-secondary { background-color: #536b7b; }
    .md\:text-primary { color: #fdfdf7; }
    .md\:text-secondary { color: #536b7b; }
}

</style>
