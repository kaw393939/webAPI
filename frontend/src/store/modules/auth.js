import router from "../../router";
import { setToken, getToken } from "../../utilities/localStorage";
import { EventBus } from "../../utilities/eventBus";

const state = {
    token: getToken(),
    error: "",
    user: ""

};

const getters = {
    isLoggedIn: state => !!state.token,
    error: state => state.error,
    userData: state => state.user,
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
                console.log(res.data);
                EventBus.$emit("logged", "logged");
                setToken(res.data.token);
                router.push("/");
            })
            .catch(err => {
                commit("sendError", err.response.data.message);
                return err;
            });
    },

    getUserDetails({commit}){
        axios.get("/api/user")
        .then(res => {
            console.log("RES", res.data.user);
            // setToken(res.data);
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
        console.log("userData", userData);
        userData ? state.user = userData : state.user = "";
        console.log("USER ST", state.user);

    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
