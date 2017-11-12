const state = {
    hands: [],
}

const getters = {
    hands: state => state.hands,
}

const actions = {
    getHands({commit}, payload){
        axios.get('/action_phase/hands')
        .then(res => {
            var tmp = [];
            //var action_n = res1.data.action_n;
            for (var idx in res.data.ui){
                tmp.push(res.data.ui[idx]);
            }
            commit('updateHands', tmp);
        });
    },
    isExist(context, payload){
        axios.get('/action_phase/exist')
        .then(res => {
            if (res.data.result){
                this.$store.dispatch('updateLog', "アクションカードを選択してね。");
                this.$emit('update_phase', 'preaction');
            } else {
                this.$store.dispatch('updateLog', "アクションカードがないため、フェイズを飛ばします。");
                this.$emit('update_phase', 'prebuy');
            }
        });
    },
}

// mutations
const mutations = {
    updateHands (state, hands) {
        state.hands = hands;
    }
}

export default {
  state,
  getters,
  actions,
  mutations
}
