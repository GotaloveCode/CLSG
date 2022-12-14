// action types
export const SET_SCORES = "setScores";
export const SET_VERIFICATIONS = "setVerifications";


// mutation types
export const SET_VERIFICATION = "setVerification";
export const SET_SCORE = "setScore";
export const SET_DETERMINATION = "setDetermination";
export const SET_MONTH = "setMonth";
export const SET_YEAR = "setYear";


const state = {
    scores: {},
    determinations: {},
    verification: {},
    month:'',
    year:''
};

const getters = {
    getScores(state) {
       return state.scores;
    },
    getDeterminations(state) {
        return state.determinations;
    },
    getVerification(state) {
       return state.verification;
    },
    getMonths(state) {
       return state.month;
    },
    getYears(state) {
       return state.year;
    }
};

const actions = {
    [SET_SCORES](context,payload) {
        axios.get("/reports/score")
            .then(res => {
                context.commit(SET_SCORE,res.data.filter(e => e.type ==="Performance Score"));
                context.commit(SET_DETERMINATION,res.data.filter(e => e.type ==="Determination"));
            })
    },
    [SET_VERIFICATIONS](context,payload) {
        axios.post("/reports/get-verification",payload)
            .then(res => {
                context.commit(SET_VERIFICATION,res.data);
                context.commit(SET_MONTH,payload.month);
                context.commit(SET_YEAR,payload.year);
            })
    }

};

const mutations = {
    [SET_SCORE](state, data) {
        state.scores = data;
    },
    [SET_DETERMINATION](state, data) {
        state.determinations = data;
    },

    [SET_VERIFICATION](state, data) {
        state.verification = data;
    },
    [SET_MONTH](state, data) {
        state.month = data;
    },
    [SET_YEAR](state, data) {
        state.year = data;
    }
};

export default {
    state,
    actions,
    mutations,
    getters
};
