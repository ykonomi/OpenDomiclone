//import log from './log'

const state = {
}

const getters = {
}

const actions = {
    startCleanUpPhase({commit, dispatch}){
        dispatch('resetHandsAndPlayArea').then(() => {
            dispatch('clean').then(() => {
                dispatch('exitTurn').then(() => {
                    dispatch('startActionPhase');
                });
            });
        });
    },
    clean(){
        return axios.get('/clean');
    },
    exitTurn({commit, dispatch}){
        return axios.get('/turn_end',{params: {id : this.who_turn}});
    },
}

// mutations
const mutations = {
}

export default {
  state,
  getters,
  actions,
  mutations
}