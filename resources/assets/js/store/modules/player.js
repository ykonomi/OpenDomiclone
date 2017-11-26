const state = {
    hands: [],
    supplies: [],
    trashes: [],
    playarea: [],
    clearFocus: false,
    checks:[],
}

const getters = {
    hands: state => state.hands,
    supplies: state => state.supplies,
    trashs: state => state.trashs,
    playarea: state => state.playarea,
    clearFocus: state => state.clearFocus,
    checkedHands: state => state.checks,
}

const actions = {
    resetHandsAndPlayArea({dispatch}){
        return dispatch('getHandsAndPlayArea').then(() => {
            dispatch('clearCheckedCards');
        });
    },
    getHandsAndPlayArea({commit}){
        //TODO Vue.nextTickは必要ない。
        return Vue.nextTick(() => {
            axios.get('/hands_and_playarea').then(res => {
                commit('updateHands',    res.data.hands);
                commit('updatePlayArea', res.data.playarea);
            });
        });
    },
    getHands ({commit}){
        return Vue.nextTick(() => {
            axios.get('/hands').then(res => {
                commit('updateHands', res.data.ui);
            })
        });
    },
    getSupplies ({commit}){
        return Vue.nextTick(() => {
            axios.get('/supplies').then(res => {
                commit('updateSupplies', res.data.ui);
            });
        });
    },
    getPlayArea ({commit}){
        return Vue.nextTick(() => {
            axios.get('/playarea').then(res => {
                commit('updatePlayArea', res.data.ui);
            });
        });
    },
    getTrashes ({commit}){
        return Vue.nextTick(() => {
            axios.get('/trashes').then(res => {
                commit('updateTrashes', res.data.ui);
            });
        });
    },
    /*
    isChecked({commit, dispatch}){
        return axios.get('/buy_phase/check', {params: {checks: state.checks, id: state.buyId}});
    },
    */
    clearCheckedCards({commit}){
        commit('cleanChecks');
        commit('enableClearFocus');
        Vue.nextTick(() => { commit('disableClearFocus'); });
    },
}

// mutations
const mutations = {
    addChecks (state, check){
        if (state.checks.indexOf(check) >= 0){
            state.checks = state.checks.filter((x) => x !== check);
        } else {
            state.checks.push(check);
        }
    },
    cleanChecks (state){
        state.checks = [];
    },
    updateHands (state, hands){
        state.hands = hands;
    },
    updateSupplies (state, supplies){
        state.supplies = supplies;
    },
    updatePlayArea (state, playarea){
        state.playarea = playarea;
    },
    updateTrashes (state, trashes){
        state.trashes = trashes;
    },
    enableClearFocus(state){
        state.clearFocus = true;
    },
    disableClearFocus(state){
        state.clearFocus = false;
    }
}

export default {
  state,
  getters,
  actions,
  mutations
}
