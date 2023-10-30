<template>
    <ProjectsTable :projects="projects"></ProjectsTable>
</template>
  
<script setup>
    import ProjectsTable from '@/Pages/Projects/Partials/ProjectsTable.vue';

    const props = defineProps({
        projects: Object
    });
</script>