//import log from './log'

const state = {
    hands: [],
    supplies: [],
    playarea: [],
    isActive: false,
    checks:[],
    buyId: 0,
    showNoActionButton: false,
    showBuyButton: false
}

const getters = {
    hands: state => state.hands,
    supplies: state => state.supplies,
    playarea: state => state.playarea,
    showNoActionButton: state => state.showNoActionButton,
    showBuyButton: state => state.showBuyButton,
    isActive: state => state.isActive,
}

const actions = {
    getHands ({commit}){
        return axios.get('hands').then(res => {
            commit('updateHands', res.data.ui);
        });
    },
    getSupplies ({commit}){
        return axios.get('/supplies').then(res => {
            commit('updateSupplies', res.data.ui);
        });
    },
    getPlayArea ({commit}){
        return axios.get('/playarea').then(res => {
            commit('updatePlayArea', res.data.ui);
        });
    },
    startActionPhase ({commit, dispatch}){
        dispatch('exist').then((res) => {
            if (res.data.result){
                commit('update', "アクションカードを選択してね。");
                commit('appearNoActionButton');
                dispatch('toNextPhase', 'action');
            } else {
                commit('update', "アクションカードがないため、フェイズを飛ばします。");
                commit('disappearNoActionButton');
                dispatch('toNextPhase', 'prebuy');
            }
        });
    },
    exist(){
        return axios.get('/action_phase/exist');
    },
    isActionCard({commit, dispatch}, index){
        return axios.get('/action_phase/is_action', {params: {idx : index}}).then(res => {
            if (res.data.result){
                commit('update', "アクションカードをプレイします。");
                dispatch('action', index);
            } else {
                commit('update', 'それはアクションカードではありません。');
            }
        });
    },
    action({commit, dispatch}, index){
        return axios.get('/action_phase/action', {params: {idx : index}}).then(res => {
            dispatch('getHands').then(() => {
                dispatch('getPlayArea').then(() => {
                    dispatch('resetFocus');
                    if (res.data.action_count != 0){
                        dispatch('startActionPhase');
                    } else {
                        commit('disappearNoActionButton');
                        dispatch('toNextPhase', 'prebuy');
                    }
                });
            });
        });
    },
    startBuyPhase({commit, dispatch}, buyId){
        dispatch('resetFocus');
        commit('disappearBuyButton');
        commit('cleanChecks');
        commit('register', buyId);
        dispatch('estimate', buyId).then(res => {
            if (res.data.result){
                commit('update', "財宝カードを選択してください。");
                dispatch('toNextPhase', 'buy');
            } else {
                commit('update', "そのカードは高くて買えません。");
            }
        });
    },
    estimate({commit, dispatch}, id){
        return axios.get('/buy_phase/estimate', {params: {id: id}});
    },
    buy({commit, dispatch}){
        dispatch('isChecked').then(res => {
            if (res.data.result) {
                axios.get('/buy_phase/buy', 
                    {params: {checks: state.checks, id: state.buyId}}).then(res => {
                        commit('disappearBuyButton');
                        commit('cleanChecks');
                        dispatch('getHands').then(() => {
                            dispatch('getPlayArea').then(() => {
                                if (res.data.buy_count != 0){
                                    dispatch('toNextPhase', 'prebuy');
                                } else {
                                    dispatch('startCleanUpPhase');
                                    commit('update', "カードを購入致しました");
                                }

                            });
                        });
                            
                    });
            } else {
                commit('update', "金がたりません");
            }
        });
    },
    isChecked({commit, dispatch}){
        return axios.get('/buy_phase/check', {params: {checks: state.checks, id: state.buyId}});

    },
    startCleanUpPhase({commit, dispatch}){
        dispatch('toNextPhase', 'clean');
        dispatch('clean').then(() => {
            dispatch('getHands').then(() => {
                dispatch('getPlayArea').then(() => {
                    dispatch('resetFocus');
                    dispatch('exitTurn').then(() => {
                        dispatch('startActionPhase');
                    });
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
    resetFocus({commit}){
        commit('activate');
        Vue.nextTick(() => {
            commit('disactivate');
        })
    }
}

// mutations
const mutations = {
    appearNoActionButton (state) {
        state.showNoActionButton = true;
    },
    disappearNoActionButton (state) {
        state.showNoActionButton = false;
    },
    appearBuyButton (state) {
        state.showBuyButton = true;
    },
    disappearBuyButton (state) {
        state.showBuyButton = false;
    },
    activate (state){
        state.isActive = true;
    },
    disactivate (state){
        state.isActive = false;
    },
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
    updateHands (state, hands) {
        state.hands = hands;
    },
    updateSupplies (state, supplies) {
        state.supplies = supplies;
    },
    updatePlayArea (state, playarea) {
        state.playarea = playarea;
    },
    register(state, id){
        state.buyId = id;
    }
}

export default {
  state,
  getters,
  actions,
  mutations
}
