window.Vue = require('vue');
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
 state: {
   token: ''
 },
 getters: {
   token(state){
     return state.token;
   }
 },
 mutations: {
   changeToken (state, payload) {
     state.token = payload
   }
 },
 actions: {}
});
