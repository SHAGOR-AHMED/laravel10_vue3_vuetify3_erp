import { createStore } from 'vuex'

const store = createStore({

  state : {
    auth: null,
    roles: null,
  },

  getters : {
      getAuth(state){
          return state.auth;
      },

      getRoles(state){
          return state.roles;
      }
  
  },

  mutations : {
      // Auth User
      setAuth(state, data){
          state.auth = data
      },

      // User Roles
      setRoles(state, data){
          state.roles = data
      },
  
  },

  actions :  {
      
  },

});

export default store;