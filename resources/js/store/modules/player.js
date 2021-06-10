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
    //ターンの開始に呼び出すメソッド
    //現在のターンが自分のターンかをリクエストし、
    //自分のターンの場合、アクションフェイズを開始する。
    start({commit, dispatch}){
        axios.get('/turns/player').then(e => {
            if (e.data.is_turn){
                dispatch('getSupplies').then(() =>{
                    dispatch('startActionPhase');
                });
            } else {
                dispatch('getSupplies');
            }
        });
    },
    resetHandsAndPlayArea({dispatch}){
        return dispatch('getHandsAndPlayArea').then(() => {
            dispatch('clearCheckedCards');
        });
    },
    getHandsAndPlayArea({commit}){
        return axios.get('/hands_and_playarea').then(res => {
            commit('updateHands',    res.data.hands);
            commit('updatePlayArea', res.data.playarea);
        });
    },
    getHands ({commit}){
        return axios.get('/hands').then(res => {
            commit('updateHands', res.data.ui);
        })
    },
    getSupplies ({commit}){
        return axios.get('/supplies').then(res => {
            commit('updateSupplies', res.data.ui);
        })
    },
    getPlayArea ({commit}){
        axios.get('/playarea').then(res => {
            commit('updatePlayArea', res.data.ui);
        })
    },
    getTrashes ({commit}){
        axios.get('/trashes').then(res => {
            commit('updateTrashes', res.data.ui);
        })
    },
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
