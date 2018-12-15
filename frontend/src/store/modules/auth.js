import router from "../../router";
import { setToken, getToken } from "../../utilities/localStorage";

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
    signUp({ commit }, obj) {
        return axios
            .post("api/register", obj)
            .then(res => {
                console.log("signup");
                router.push("/login");
            })
            .catch(err => {
                commit("sendError", err.response.data.errors.email[0]);
                return err;
            });
    },
    login({ commit }, obj) {
        axios
            .post("api/login", obj)
            .then(res => {
                console.log("login");
                setToken(res.data.token);
                console.log(res);
                router.push("/");
                commit("setLoggedState", res.data.token);
            })
            .catch(err => {
                commit("sendError", err.response.data.message);
                return err;
            });
    },

    getUserDetails({ commit }) {
        axios
            .get("/api/user")
            .then(res => {
                commit("sendUserData", res.data.user);
                console.log("res", res);
            })
            .catch(err => {
                console.log(error);
            });
    },

    logout: ({ commit }) => {
        console.log("logout");
        commit("setLoggedState", null);
        localStorage.removeItem("token");
        console.log(localStorage.getItem("token"));
    },

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
