<template>
    <form @submit.prevent="add">
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" v-model="player.first_name">
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" v-model="player.last_name">
        </div>
        <div class="form-group">
            <div class="row">

                <div class="col-md-3">
                    <label for="last_name">Team</label>
                    <select class="form-control" id="team" v-model="player.team.id">
                        <option v-for="team in teams" v-bind:value="team.id">{{team.name}}</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="last_name">Start</label>
                    <input type="date" class="form-control" id="start" v-model="player.team.start">
                </div>


                <div class="col-md-3">
                    <label for="last_name">End</label>
                    <input type="date" class="form-control" id="end" v-model="player.team.end">

                </div>
            </div>
        </div>

        <div class="pull-right">
            <button type="submit" class="btn btn-success">Save</button>
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
        name: "NewPlayer",
        mounted() {
            this.$store.dispatch('getTeams');
        },
        data() {
            return {
                player: {
                    first_name: null,
                    last_name: null,
                    team: {
                        id: null,
                        start: null,
                        end: null,
                    },
                },
                errors: null
            }
        },
        computed: {
            loggedUser() {
                return this.$store.getters.getLoggedUser;
            },
            teams() {
                return this.$store.getters.getTeams;
            }
        },
        methods: {
            add() {
                this.errors = null;
                const constraints = this.getConstraints();
                const player = this.$data.player;
                const errors = validate(player, constraints);
                if (errors) {

                    this.errors = errors;

                    return;
                }

                axios.post('/api/players', player).then((response) => {
                    this.$router.push('/players');
                });

            },
            getConstraints() {
                return {
                    first_name: {
                        presence: {allowEmpty: false},
                        length: {
                            minimum: 3,
                            message: 'A player name should not be so short. Please make it at least 3 characters.!'
                        }
                    },
                    last_name: {
                        presence: {allowEmpty: false},
                        length: {
                            minimum: 3,
                            message: 'A player name should not be so short. Please make it at least 3 characters.!'
                        }
                    }
                }
            }
        }

    }
</script>

<style scoped>

</style>