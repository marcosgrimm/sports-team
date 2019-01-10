<template>
    <form @submit.prevent="add">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" v-model="team.name">
        </div>
        <div class="pull-right">

            <button type="submit" class="btn btn-success">Edit</button>
        </div>

        <template v-if="errors">
            <div v-for="(errorMsgs,inputName) in errors" :key="inputName" class="alert alert-danger text-center"
                 role="alert">
                <b>{{inputName}}</b>: {{errorMsgs.join(',')}}
            </div>
        </template>
    </form>
</template>

<script>
    export default {
        name: "Team",

        computed: {
            loggedUser() {
                return this.$store.getters.getLoggedUser;
            }
        },
        data() {
            return {
                team: {
                    name: null
                },
                errors: null
            }
        },
        created() {
            axios.get(`/api/teams/${this.$route.params.id}`, {
                headers: {
                    "Authorization": "Bearer " + this.loggedUser.token
                }
            }).then((response) => {
                this.team = response.data.team;
            });
        },

    }
</script>

<style scoped>

</style>