import Vue from "vue"
import Vuex from "vuex"
import VuexPersistence from 'vuex-persist'
Vue.use(Vuex);

const vuexLocal = new VuexPersistence({
  storage: window.localStorage
});

const store = new Vuex.Store({
  state: {
    search: "",
    app_name: localStorage.getItem("app_name"),
    auth: {
      loggedIn: false,
      token: null,
      user: null
    },
    voter:{
      data:'',
      message:'',
      status:false
    },
    qrCode:true,
    primary_color: "#2858af"
  },
  mutations: {
    _loggedIn(state, value) {
      state.auth.loggedIn = value;
    },
    _token(state, value) {
      state.auth.token = value;
    },
    _profile(state, value) {
      state.auth.user = value;
    },
    _search(state, value) {
      state.search = value;
    },
    _voter(state, value){
      state.voter = value;
    },
    _qr(state, value){
      state.qrCode = value;
    }

  },
  actions: {},
  plugins: [vuexLocal.plugin],
});

export default store;
