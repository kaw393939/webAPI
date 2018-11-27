import axios from "axios";

const state = {
  token: null
};

const getters = {
  isLoggedIn: state => !!state.token
};

const actions = {
  signUp: ({commit}, obj) => {
    axios.post("api/register", obj ).then(res => console.log("RES", res)).catch(err => {
      console.log("ERR", err.response);
    });
  },
  login: ({commit}, obj) => {
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