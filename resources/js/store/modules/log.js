const state = {
    log: "",
}

const getters = {
    log: state => state.log,
}

const actions = {
}

// mutations
const mutations = {
    updateMessage (state, log) {
        state.log = log + '\n' + state.log;
    }
}

export default {
  state,
  getters,
  actions,
  mutations
}
