<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Projects from '@/Pages/Projects/Projects.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    projects: {
        type: Object,
    }
});
</script>

<template>
    <Head title="Projects Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Projects Dashboard</h2>
        </template>

        <Projects :projects="projects"></Projects>
    </AuthenticatedLayout>
</template>
