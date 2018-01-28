//import log from './log'

const state = {
    showNoActionButton: false,
}

const getters = {
    showNoActionButton: state => state.showNoActionButton,
}

const actions = {
    startActionPhase ({commit, dispatch}){
        dispatch('resetHandsAndPlayArea').then(() => {
            dispatch('exist').then(res => {
                commit('update', res.data.log);
                if (res.data.result){
                    commit('appearNoActionButton');
                    dispatch('toNextPhase', 'Action');
                } else {
                    commit('disappearNoActionButton');
                    dispatch('startBuyPhase');
                }
            });
        });
    },
    exist(){
        return axios.get('/action_phase/exist');
    },
    isActionCard({commit, dispatch}, index){
        return axios.get('/action_phase/is_action', 
            {params: {idx : index}}).then(res => {
                commit('update', res.data.log);
                if (res.data.result){
                    dispatch('action', index);
                }
            });
    },
    action({commit, dispatch}, index){
        return axios.get('/action_phase/action', {params: {idx : index}}).then(res => {
            dispatch('resetHandsAndPlayArea').then(() => {
                if (res.data.pattern == 1){
                    dispatch('updateLog', res.data.log);
                    commit('disappearNoActionButton');
                    dispatch('toNextPhase','Chapel');
                } else {
                    if (res.data.action_count != 0){
                        dispatch('startActionPhase');
                    } else {
                        commit('disappearNoActionButton');
                        commit('setupBuySelection', res.data.plus_buy);
                        dispatch('startBuyPhase');
                    }
                }
            });
        });
    },
    //Comming Soon...
    tryChapel({commit, dispatch}, value){
        commit('addChecks', value);
        if (state.checks.length == 4){
            dispatch('resetfocus');
            commit('cleanChecks');
            dispatch('send').then();
        }
    },
    send({commit, dispatch}, value){
        return axios.get('/action_phase/chapel', {params: {checks : state.checks}}).then(res => {
            //res.data.
                //廃棄カードをデータベースに
                //する
            

        });
    },
}

// mutations
const mutations = {
    appearNoActionButton (state) {
        state.showNoActionButton = true;
    },
    disappearNoActionButton (state) {
        state.showNoActionButton = false;
    },
}

export default {
  state,
  getters,
  actions,
  mutations
}
