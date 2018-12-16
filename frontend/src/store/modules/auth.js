import router from "../../router";
import { setToken, getToken } from "../../utilities/localStorage";
import { setAuthToken } from "@/utils/LocalStorageUtils";

const state = {
    token: getToken(),
    error: "",
    user: "",
    authUser: {},
    isLogged: false
};

const getters = {
    isLoggedIn: state => state.isLogged,
    error: state => state.error,
    userData: state => state.user
};

const actions = {
    clearErrors: ({ commit }) => {
        console.log("clear");
        commit("removeErrors");
    }
};

const mutations = {
    sendError: (state, error) => {
        state.error = error;
    },
    sendUserData: (state, userData) => {
        userData ? (state.user = userData) : (state.user = "");
    },
    setLoggedState(state, authToken) {
        if (authToken) state.isLogged = true;
        else state.isLogged = false;
    },
    removeErrors: state => {
        state.error = "";
    },

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
    actions,
    mutations
};
