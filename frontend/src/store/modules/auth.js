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
        const handleResponse = response => {
            const { token } = response.data;

            setAuthToken(token);
            window.axios.defaults.headers.common[
                "Authorization"
            ] = `Bearer ${token}`;

            router.push("/");
            commit("setLoggedState", token);
        };

        const handleError = error => {
            const { message } = error.response.data;

            commit("sendError", message);
        };

        axios
            .post("api/login", obj)
            .then(handleResponse)
            .catch(handleError);
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
