//import log from './log'

const state = {
    buyId: 0,
    showBuyButton: false,
    selected: 0,
    plusBuy: [],
    showBuySelection: false
}

const getters = {
    showBuyButton: state => state.showBuyButton,
    showBuySelection: state => state.showBuySelection,
    plusBuy: state => state.plusBuy,
    selected: state => state.selected,

}

const actions = {
    startBuyPhase({commit, dispatch}){
        dispatch('resetHandsAndPlayArea').then(() => {
            commit('appearBuySelection');
            dispatch('updateLog', "購入するカードを選択してください。");
            dispatch('toNextPhase', 'BeforeBuy');
        });
    },
    selectCards({commit, dispatch}, buyId){
        dispatch('clearCheckedCards').then(() => {
            commit('disappearBuyButton');
            commit('register', buyId);
            dispatch('estimate', buyId).then(res => {
                if (res.data.result){
                    commit('update', "財宝カードを選択してください。");
                    if (res.data.is_zero){
                        commit('appearBuyButton');
                    }
                    dispatch('toNextPhase', 'Buy');
                } else {
                    commit('update', "そのカードは高くて買えません。");
                }
            });
        });
    },
    estimate({commit, dispatch}, id){
        return axios.get('/buy_phase/estimate', {params: {id: id}});
    },
    buy({commit, dispatch, rootState}){
        dispatch('isChecked').then(res => {
            if (res.data.result) {
                var checks = rootState.player.checks;
                axios.get('/buy_phase/buy', {params: {checks: checks, id: state.buyId}}).then(res => {
                    commit('disappearBuyButton');
                    commit('disappearBuySelection');
                    if (res.data.is_gone){
                        dispatch('getSupplies');
                    }
                    if (res.data.buy_count != 0){
                        dispatch('startBuyPhase');
                    } else {
                        dispatch('startCleanUpPhase');
                    }

                });
            }
            commit('update', res.data.log);
        });
    },
    isChecked({commit, dispatch, rootState}){
        var checks = rootState.player.checks;
        return axios.get('/buy_phase/check', {params: {checks: checks, id: state.buyId}});

    },
}

// mutations
const mutations = {
    appearBuyButton (state) {
        state.showBuyButton = true;
    },
    disappearBuyButton (state) {
        state.showBuyButton = false;
    },
    appearBuySelection (state) {
        if (state.plusBuy.length > 1){
            state.showBuySelection = true;
        }
    },
    disappearBuySelection (state) {
        state.showBuySelection = false;
        state.plusBuy = [];
    },
    setupBuySelection(state, plusBuy) {
        state.plusBuy = [];
        for (var i = 0; i < plusBuy + 1; ++i) {
            state.plusBuy.push(i);
        }
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