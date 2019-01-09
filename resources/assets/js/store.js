export default {
    state: {
        welcomeMessage: 'Welcome to my vue'
    },
    getters: {
        welcome(state) {
            return state.welcomeMessage;
        }
    },
    mutations: {},
    actions: {}
}