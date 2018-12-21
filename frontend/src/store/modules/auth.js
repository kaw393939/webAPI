const state = {
    authUser: {},
    isLogged: false
};

const getters = {
    authUser: state => state.authUser,
    isLoggedIn: state => state.isLogged
};

const mutations = {
    setAuthUser(state, payload) {
        state.authUser = { ...payload.data };
        state.isLogged = true;
    },

    resetAuthUser(state) {
        state.authUser = {};
        state.isLogged = false;
    }
};

export default {
    state,
    getters,
    mutations
};
