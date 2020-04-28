<template>
    <div>
        <div v-if="loading">
            Loading...
        </div>
        <div v-else>
            <div v-if="projects.length === 0">
                <p>No projects yet.
                    <router-link to="/project/create">Get started</router-link>
                </p>
            </div>

            <div v-for="project in projects">
                <router-link :to="'/projects/' + project.data.project_id"
                             class="flex items-center border-b border-gray-400 p-4 hover:bg-gray-100">

                    <div class="">
                        <p class="text-blue-400 font-bold">{{ project.data.name }}</p>
                        <p class="text-gray-600">{{ project.data.company }}</p>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "ProjectsList",

        components: {
        },

        props: [
          'endpoint',
        ],

        mounted() {
            axios.get(this.endpoint)
                .then(response => {
                    this.projects = response.data.data;

                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;

                    alert('Unable to fetch projects.');
                });
        },

        data: function () {
            return {
                loading: true,
                projects: null,
            }
        }
    }
</script>

<style scoped>

</style>
