// start
// preaction 
// action1 action2 action3 action4 attack1 attack2
// 
// 
//

const state = {
    phase: 'start',
}

// getters
const getters = {
    phase: state => state.phase
}

// actions
const actions = {
    toNextPhase ({commit}, nextPhase){
        commit('some', nextPhase);
    }
}

// mutations
const mutations = {
    //1: state, 2:payload
    some (state, nextPhase) {
        state.phase = nextPhase;
    }
}

export default {
  state,
  getters,
  actions,
  mutations
}
