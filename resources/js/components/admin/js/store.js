import { createStore } from 'vuex'

const store = createStore({

  state : {
    auth: null,
    count:100
  },

  getters : {
      getAuth(state){
          return state.auth;
      }
  
  },

  mutations : {
      // Auth User
      setAuth(state, data){
          state.auth = data
      },
  
  },

  actions :  {
      
  },

});

export default store;