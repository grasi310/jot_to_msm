<template>
    <ProjectsList endpoint="/api/projects" />
</template>

<script>
    import ProjectsList from "../components/ProjectsList";

    export default {
        name: "ProjectsIndex",

        components: {
            ProjectsList,
        }
    }
</script>

<style scoped>

</style>
