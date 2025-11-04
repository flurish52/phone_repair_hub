<template>
    <nav class="fixed top-0 left-0 right-0 z-40 bg-white shadow flex items-center justify-between px-6 py-3">
        <!-- Left side -->
        <h1
            v-if="!$page.props.auth.user"
             class="flex items-center space-x-4">
            <Link href="/" class="text-xl md:ml-64 font-semibold text-gray-800">Phixobel</Link>
        </h1>
        <h1
            v-else
             class="flex items-center space-x-4 hidden md:block">
            <Link href="/" class="text-xl md:ml-64 font-semibold text-gray-800">Phixobel</Link>
        </h1>

        <!-- Right side -->
        <div class="flex items-center  space-x-4">
            <template
                v-if="!$page.props.auth.user"
            >
                <Link href="/login" class="flex items-center justify-between mx-1 text-gray-700 hover:text-gray-900">
                    <span class="mx-1">Login</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-7.5A2.25 2.25 0 003.75 5.25v13.5A2.25 2.25 0 006 21h7.5a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H6"/>
                    </svg>
                </Link>
                <Link href="/register" class="flex items-center justify-between mx-1 text-gray-700 hover:text-gray-900">
                    <span class="mx-1">Register</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19a6 6 0 00-12 0M9 11a4 4 0 100-8 4 4 0 000 8zM19 8v6m3-3h-6"/>
                </svg>


                </Link>
            </template>
            <template v-else class="flex justify-between items-center px-6">
                <Link href="/" class="text-gray-700 font-medium">
                    {{ $page.props.auth.user.name.length > 10
                    ? $page.props.auth.user.name.substring(0, 10) + '...'
                    : $page.props.auth.user.name }}
                </Link>

                <Link href="/dashboard" class="flex bg-secondary p-1 rounded-md text-primary hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 13.5A1.5 1.5 0 014.5 12h3A1.5 1.5 0 019 13.5v6A1.5 1.5 0 017.5 21h-3A1.5 1.5 0 013 19.5v-6zM10.5 3A1.5 1.5 0 0112 4.5v15A1.5 1.5 0 0110.5 21h-3A1.5 1.5 0 016 19.5v-15A1.5 1.5 0 017.5 3h3zM18 10.5A1.5 1.5 0 0119.5 12v7.5A1.5 1.5 0 0118 21h-3A1.5 1.5 0 0113.5 19.5V12A1.5 1.5 0 0115 10.5h3z"/>
                    </svg>
                    <span>Dashboard</span>
                </Link>
                <Link
                    href="/logout"
                    method="post"
                    as="button"
                    class="text-red-600 hover:text-red-700 flex"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-7.5A2.25 2.25 0 003.75 5.25v13.5A2.25 2.25 0 006 21h7.5a2.25 2.25 0 002.25-2.25V15M18 12H9m9 0l-3 3m3-3l-3-3"/>
                    </svg>
                    <span>Logout</span>

                </Link>
            </template>
        </div>
    </nav>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<style scoped>
nav {
    height: 60px;
}
</style>
