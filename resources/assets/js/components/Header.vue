<template>
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <router-link class="navbar-brand" to="/">My Vue App</router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li>
                    <router-link to="/login" class="nav-link">Login</router-link>
                </li>
                <li>
                    <router-link to="/register" class="nav-link">Register</router-link>
                </li>

            </ul>
        </div>
        <div class="container">
        </div>
    </nav>
</template>

<script>
    export default {
        name: 'app-header',
        methods: {
            logout() {
                this.$store.commit('logout');
                this.$router.push('/login');
            }
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser
            }
        }
    }
</script>