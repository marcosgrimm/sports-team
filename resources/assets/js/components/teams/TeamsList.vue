<template>
    <table class="table table-striped">
        <thead>
            <th class="col-md-1 text-center">ID</th>
            <th>Name</th>
            <th class="col-md-1 text-center"><span class="glyphicon glyphicon-cog"></span> </th>
        </thead>
        <tbody>
        <template v-if="!teams.length">
            <tr>
                <td colspan="2">No teams registered yet.</td>
            </tr>
        </template>
        <template v-else>
            <tr v-for="team in teams" >
                <td>{{team.id}}</td>
                <td>{{team.name}}</td>
                <td  class="text-center">
                    <router-link :to="`/teams/${team.id}`">Edit</router-link>
                </td>
            </tr>
        </template>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "TeamsList",
        mounted(){
            this.$store.dispatch('getTeams');
        },
        computed: {
            teams(){
                return this.$store.getters.getTeams;
            }
        }
    }
</script>

<style scoped>

</style>