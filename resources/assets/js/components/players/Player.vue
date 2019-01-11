<template>
    <div>
        <form @submit.prevent="edit">
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
                        <select class="form-control" id="team" v-model="team.id">
                            <option v-for="team in teams" v-bind:value="team.id">{{team.name}}</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="last_name">Start</label>
                        <input type="date" class="form-control" id="start" v-model="team.start">
                    </div>


                    <div class="col-md-3">
                        <label for="last_name">End</label>
                        <input type="date" class="form-control" id="end" v-model="team.end">
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12 ">
                    <button type="submit" class="btn btn-success pull-right">Save</button>
                </div>
            </div>
            <template v-if="errors">
                <div v-for="(errorMsgs,inputName) in errors" :key="inputName" class="alert alert-danger text-center"
                     role="alert">
                    <b>{{inputName}}</b>: {{errorMsgs.join(',')}}
                </div>
            </template>
        </form>
        <br/>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Team Contracts
                    </div>
                    <div class="panel-body">
                        <template v-if="!storedTeams">
                            <tr>
                                <td colspan="2">No teams for this player yet.</td>
                            </tr>
                        </template>
                        <template v-else>
                            <table class="table table-striped">
                                <thead>
                                    <th>Team</th>
                                    <th class="col-md-1 text-center">Start</th>
                                    <th class="col-md-1 text-center">End</th>
                                    <th class="col-md-1 text-center"><span class="glyphicon glyphicon-cog"></span></th>
                                </thead>
                                <tbody>
                                <tr v-for="storedTeam in storedTeams">
                                    <td>{{storedTeam.team.name}}</td>
                                    <td class="col-md-1 text-center">{{storedTeam.start}}</td>
                                    <td class="col-md-1 text-center">{{storedTeam.end}}</td>
                                    <td class="text-center">

                                        <button @click.prevent="deletePlayerTeam(storedTeam.id)" class="btn btn-danger btn-xs"><span
                                                class="glyphicon glyphicon-remove-sign"></span></button>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import validate from 'validate.js';

    export default {
        name: "Player",

        computed: {
            loggedUser() {
                return this.$store.getters.getLoggedUser;
            },
            players() {
                return this.$store.getters.getPlayers;
            },
            teams() {
                return this.$store.getters.getTeams;
            }

        },
        data() {
            return {
                player: {
                    first_name: null,
                    last_name: null,
                },
                team: {
                    id: null,
                    start: null,
                    end: null,
                },
                storedTeams: null,
                errors: null
            }
        },
        created() {
            if (this.players) {
                this.player = this.players.find((player) => player.id == this.$route.params.id);
            } else {
                axios.get(`/api/players/${this.$route.params.id}`).then((response) => {
                    this.player = response.data.player;
                });
            }

            this.getStoredTeams();
            this.$store.dispatch('getTeams');

        },
        methods: {
            getStoredTeams() {
                axios.get(`/api/players/${this.$route.params.id}/teams`).then((response) => {
                    if (response.data.playerTeams.length){

                        this.storedTeams = response.data.playerTeams;
                    }
                });
            },
            edit() {
                this.errors = null;
                const constraints = this.getConstraints();
                const player = this.$data.player;
                const team = this.$data.team;
                const errors = validate(player, constraints);
                if (errors) {
                    this.errors = errors;
                    return;
                }

                axios.post('/api/players/' + this.$route.params.id, {player:player, team:team}).then((response) => {
                    this.getStoredTeams();
                    this.team =  {
                        id: null,
                            start: null,
                            end: null,
                    };
                });

            },
            deletePlayerTeam(teamId) {
                axios.delete('/api/teams/'+teamId+'/players/'+this.$route.params.id)
                    .then((response) => {
                        this.getStoredTeams();

                    })
            },
            getConstraints() {
                return {
                    first_name: {
                        presence: {  allowEmpty: false },
                        length: {
                            minimum: 3,
                            message: 'A player name should not be so short. Please make it at least 3 characters.!'
                        }
                    },
                    last_name: {
                        presence: {  allowEmpty: false },
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