<template>
    <div>
        <div class="flex justify-between">
            <a href="#" class="text-blue-400" @click="$router.back()">
                < Back
            </a>
        </div>

        <form @submit.prevent="submitForm">
            <InputField name="name" label="Project Name" :errors="errors" placeholder="Project Name"
                        @update:field="form.name = $event"></InputField>
            <InputField name="company" label="Company" :errors="errors" placeholder="Company"
                        @update:field="form.company = $event"></InputField>
            <InputField name="location" label="Location" :errors="errors" placeholder="Location"
                        @update:field="form.location = $event"></InputField>
            <InputField name="description" label="Description" :errors="errors" placeholder="Description"
                        @update:field="form.description = $event"></InputField>

            <div class="flex justify-end">
                <button class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">Cancel</button>
                <button class="bg-blue-500 py-2 px-4 rounded text-white hover:bg-blue-400">Save</button>
            </div>
        </form>
    </div>
</template>

<script>
    import InputField from "../components/InputField";

    export default {
        name: "ProjectsCreate",

        components: {
            InputField
        },

        mounted() {
            axios.get('/api/projects/' + this.$route.params.id)
                .then(response => {
                    this.form = response.data.data;

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
                form: {
                    'name': '',
                    'company': '',
                    'location': '',
                    'description': '',
                },

                errors: null,
            }
        },

        methods: {
            submitForm: function () {
                axios.patch('/api/projects/' + this.$route.params.id, this.form)
                    .then(response => {
                        this.$router.push(response.data.links.self);
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
