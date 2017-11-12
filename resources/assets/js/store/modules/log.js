const state = {
    log: "",
}

const getters = {
    log: state => state.log,
}

const actions = {
    updateLog (context, payload){
        context.commit('update', payload); 
    }
}

// mutations
const mutations = {
    update (state, log) {
        state.log = log;
    }
}

export default {
  state,
  getters,
  actions,
  mutations
}
