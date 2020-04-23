<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <div class="flex justify-between">
                <a href="#" class="text-blue-400" @click="$router.back()">
                    < Back
                </a>
                <div class="relative">
                    <router-link :to="'/projects/' + project.project_id + '/edit'"
                                 class="px-4 py-2 rounded text-sm text-green-500 border border-green-500 text-sm font-bold mr-2">
                        Edit
                    </router-link>
                    <a href="#"
                       class="px-4 py-2 border border-red-500 rounded text-sm font-bold text-red-500"
                       @click="modal = ! modal">Delete</a>

                    <div v-if="modal"
                         class="absolute bg-blue-900 text-white rounded-lg z-20 p-8 w-64 right-0 mt-2 mr-6">
                        <p>Are you sure you want to delete this record?</p>

                        <div class="flex items-center mt-6 justify-end">
                            <button class="text-white pr-4" @click="modal = ! modal">Cancel</button>
                            <button class="px-4 py-2 bg-red-500 rounded text-sm font-bold text-white" @click="destroy">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div v-if="modal" class="bg-black opacity-25 absolute right-0 left-0 top-0 bottom-0 z-10"
                     @click="modal = ! modal"></div>
            </div>

            <div class="flex justify-between">
                <div>
                    <div class="flex items-center pt-6">
                        <UserCircle :name="project.name"/>

                        <p class="pl-5 text-xl">{{ project.name }}</p>
                    </div>

                    <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Company</p>
                    <p class="pt-2 text-blue-400">{{ project.company }}</p>


                    <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Location</p>
                    <p class="pt-2 text-blue-400">{{ project.location }}</p>


                    <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Description</p>
                    <p class="pt-2 text-blue-400">{{ project.description }}</p>
                </div>

                <div id="mapBox" class="z-10 pt-8">
                    <Map></Map>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import UserCircle from "../components/UserCircle";
    import Map from "../components/Map";


    export default {
        name: "ProjectsShow",

        components: {
            UserCircle,
            Map,
        },

        mounted() {
            axios.get('/api/projects/' + this.$route.params.id)
                .then(response => {
                    this.project = response.data.data;

                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;

                    if (error.response.status === 404) {
                        this.$router.push('/projects');
                    }
                });
        },

        data: function () {
            return {
                loading: true,
                modal: false,
                project: null,
            };
        },

        methods: {
            destroy: function () {
                axios.delete('/api/projects/' + this.$route.params.id)
                    .then(response => {
                        this.$router.push('/projects');
                    })
                    .catch(error => {
                        alert('Internal Error. Unable to delete project.')
                    });
            },
        }
    }
</script>

<style scoped>
    #mapBox {
        width: 500px;
    }
</style>
