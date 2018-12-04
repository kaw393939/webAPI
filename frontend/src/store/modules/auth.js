import router from "../../router";
import { setToken, getToken } from "../../utilities/localStorage";

const state = {
    token: getToken(),
    error: "",
    user: "",
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
                setToken(res.data.token);
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
            })
            .catch(err => {
                console.log(error);
            });
    },
    logOut: ({ commit }) => {
        commit("setToken", null);
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
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
