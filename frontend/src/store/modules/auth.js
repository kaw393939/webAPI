import axios from "axios";
import router from "../../router";

const state = {
    token: null,
    error: ""
};

const getters = {
    isLoggedIn: state => !!state.token,
    error: state => state.error
};

const actions = {
    signUp({ commit }, obj) {
        return axios
            .post("api/register", obj)
            .then(res => router.push("/login"))
            .catch(err => {
                commit("sendError", err.response.data.errors.email[0]);
                return err;
            });
    },
    login({ commit }, obj) {
        axios
            .post("api/login", obj)
            .then(res => router.push("/"))
            .catch(err => {
                commit("sendError", err.response.data.message);
                return err;
            });
    },
    logOut: ({ commit }) => {
        commit("setToken", null);
    }
};

const mutations = {
    setToken: (state, token) => {
        state.token = token;
    },
    sendError: (state, error) => {
        state.error = error;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
