import axios from "axios";

const state = {
    token: null
};

const config = {
    headers: {
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "*",
        "Access-Control-Allow-Methods": ["GET, POST", "PUT", "DELETE"]
    }
}


const getters = {
    isLoggedIn: state => !!state.token
};

const actions = {
    signUp: ({commit}, obj) => {
        console.log("email",obj)
        console.log("this is signUp")
        axios.post("api/register", obj ).then(res => console.log("RES", res)).catch(err => {
            console.log("ERR", err.response);
        });
    },
    login: ({commit}, obj) => {
        console.log("email",obj)
        console.log("this is login")
        axios.post("api/login", obj).then(res => console.log("RES", res)).catch(err => {
            console.log("ERR", err.response);
        });
    },
    logOut: ({commit}) => {
        commit("setToken", null);
    }
};

const mutations = {
    setToken: (state, token) => {
        state.token = token;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}