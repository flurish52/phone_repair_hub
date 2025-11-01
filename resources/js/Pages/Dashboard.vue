<template>
    <AuthenticatedLayout>
        <component
            :is="currentDashboard.component"
            :items="currentDashboard.data"
        />
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import EngineerDashboard from '@/Components/Dashboards/EngineersDashboard.vue'
import VendorDashboard from '@/Components/Dashboards/VendorDashboard.vue'
import AdminDashboard from '@/Components/Dashboards/AdminDashboard.vue'

const page = usePage()
const userRole = page.props.auth?.user?.role?.toLowerCase() || 'engineer'

// Array of dashboards with their data
const dashboards = ref([
    {
        role: 'engineer',
        component: EngineerDashboard,
        data: page.props.repairs || [],
    },
    {
        role: 'vendor',
        component: VendorDashboard,
        data: page.props.products || [],
    },
    {
        role: 'user',
        component: EngineerDashboard,
        data: page.props.repairs || [],
    },
    {
        role: 'admin',
        component: AdminDashboard,
        data: page.props.repairs || [],
    },
])

// Computed dashboard for the current user role
const currentDashboard = computed(() => {
    return dashboards.value.find(d => d.role === userRole) || dashboards.value[0]
})
</script>
