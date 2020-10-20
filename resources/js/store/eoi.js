// action types
export const SET_CURRENT_STEP = "setCurrentStep";

// mutation types
export const SET_STEP = "setStep";

const state = {
    step: 1,
};

const getters = {
    getStep(state) {
        return state.step;
    }
};

const actions = {
    [SET_CURRENT_STEP](context,payload) {
       context.commit(SET_STEP,payload);
    },

};

const mutations = {
    [SET_STEP](state, data) {
        state.step = data;
        console.log("state --- "+state.step)
    },
};

export default {
    state,
    actions,
    mutations,
    getters
};
