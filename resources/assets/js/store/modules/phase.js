// start
// preaction 
// action1 action2 action3 action4 attack1 attack2
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
    toNextPhase ({commit, dispatch}, nextPhase){
        commit('to', nextPhase);
        switch (nextPhase) {
            case 'start':
                break;
            case 'action':
                break;
            case 'attack':
                break;
            case 'prebuy':
                dispatch('updateLog', "購入するカードを選択してください。");
                break;
            case 'buy':
                break;
            case 'crean':
                break;
        }
    },
    
}

// mutations
const mutations = {
    //1: state, 2:payload
    to (state, nextPhase) {
        state.phase = nextPhase;
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
