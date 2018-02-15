//import log from './log'

const state = {
}

const getters = {
}

const actions = {
    startCleanUpPhase({commit, dispatch}){
        commit('toNextPhase'); //Cleanに
        dispatch('resetHandsAndPlayArea').then(() => {
            dispatch('clean').then(() => {
                dispatch('exitTurn').then(() => {
                    commit('toNextPhase'); //Startに
                    dispatch('start');
                });
            });
        });
    },
    clean(){
        return axios.get('/clean');
    },
    exitTurn({commit, dispatch}){
        return axios.put('/turns');
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
