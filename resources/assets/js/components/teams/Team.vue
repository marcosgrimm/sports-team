<template>
    <form @submit.prevent="edit">
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
    import validate from 'validate.js';

    export default {
        name: "Team",

        computed: {
            loggedUser() {
                return this.$store.getters.getLoggedUser;
            },
            teams(){
                console.log(this.$store.getters);
                return this.$store.getters.getTeams;
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
            if (this.teams){
                this.team = this.teams.find( (team) => team.id == this.$route.params.id);
            } else {
                axios.get(`/api/teams/${this.$route.params.id}`).then((response) => {
                    this.team = response.data.team;
                });
            }
        },
        methods: {
            edit() {
                this.errors = null;
                const constraints = this.getConstraints();
                const team = this.$data.team;
                const errors = validate(team, constraints);
                if (errors){
                    this.errors = errors;
                    return;
                }

                axios.post('/api/teams/'+this.$route.params.id,team).then((response)=>{
                    this.$router.push('/teams');
                });

            },
            getConstraints() {
                return {
                    name: {
                        presence: true,
                        length: {
                            minimum: 3,
                            message: 'A team name should not be so short. Please make it at least 3 characters. Lets create a BIG team!'
                        }
                    }

                }
            }
        }
    }
</script>

<style scoped>

</style>