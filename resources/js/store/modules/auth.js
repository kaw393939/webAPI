
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