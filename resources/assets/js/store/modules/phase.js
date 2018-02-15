// start
// preaction 
// action1 action2 action3 action4 attack1 attack2
// 

const state = {
    phase: 'Start',
}

// getters
const getters = {
    phase: state => state.phase
}

// actions
const actions = {
}

// mutations
const mutations = {
    toNextPhase(state){
        switch(state.phase){
            case 'Start':
                state.phase = 'Action';
                break;
            case 'Action':
                state.phase = 'BeforeBuying';
                break;
            case 'BeforeBuying':
                state.phase = 'Buy';
                break;
            case 'Buy':
                state.phase = 'Crean';
                break;
            case 'Clean':
                state.phase = 'Start';
                break;
        }
    },
    toBackPhase(state){
        switch(state.phase){
            case 'Start':
                state.phase = 'Crean';
                break;
            case 'Action':
                state.phase = 'Start';
                break;
            case 'BeforeBuying':
                state.phase = 'Action';
                break;
            case 'Buy':
                state.phase = 'BeforeBuying';
                break;
            case 'Clean':
                state.phase = 'Buy';
                break;
        }
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
