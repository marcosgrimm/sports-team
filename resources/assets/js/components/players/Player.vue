<template>
    <form @submit.prevent="edit">
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" v-model="player.first_name">
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" v-model="player.last_name">
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
        name: "Player",

        computed: {
            loggedUser() {
                return this.$store.getters.getLoggedUser;
            },
            players(){
                console.log(this.$store.getters);
                return this.$store.getters.getPlayers;
            }
        },
        data() {
            return {
                player: {
                    first_name: null,
                    last_name: null,
                },
                errors: null
            }
        },
        created() {
            if (this.players){
                this.player = this.players.find( (player) => player.id == this.$route.params.id);
            } else {
                axios.get(`/api/players/${this.$route.params.id}`).then((response) => {
                    this.player = response.data.player;
                });
            }
        },
        methods: {
            edit() {
                this.errors = null;
                const constraints = this.getConstraints();
                const player = this.$data.player;
                const errors = validate(player, constraints);
                if (errors){
                    this.errors = errors;
                    return;
                }

                axios.post('/api/players/'+this.$route.params.id,player).then((response)=>{
                    this.$router.push('/players');
                });

            },
            getConstraints() {
                return {
                    first_name: {
                        presence: true,
                        length: {
                            minimum: 3,
                            message: 'A player name should not be so short. Please make it at least 3 characters.!'
                        }
                    },
                    last_name: {
                        presence: true,
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