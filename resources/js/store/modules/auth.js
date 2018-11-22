import axios from "axios";

const state = {
    token: null
};


const getters = {
    isLoggedIn: state => !!state.token
};

const actions = {
    login: ({commit}, obj) => {
        console.log("email",obj)
        console.log("this is login")
        axios.post("http://127.0.0.1:8000/api/login", obj).then(res => {console.log("RES", res)}).catch(err => {
            console.log("ERR", err.response);
        });
        //console.log("RESULT", result);
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