// action types
export const SET_FORMATS = "setFormats";
export const SET_REPORT_FORMATS = "setReportFormats";

// mutation types
export const SET_FORMAT = "setFormat";
export const SET_REPORT_FORMAT = "setReportFormat";
export const SET_MONTH = "setMonth";
export const SET_YEAR = "setYear";


const state = {
    formats: {},
    report_format: {},
    month:'',
    year:'',
};

const getters = {
    getFormats(state) {
        return state.formats;
    },
    getReportFormat(state) {
        return state.report_format;
    },
    getReportMonth(state) {
        return state.month;
    },
    getReportYear(state) {
        return state.year;
    },
};

const actions = {
    [SET_FORMATS](context,payload) {
        axios.get("/reports/report-format")
            .then(res => {
                context.commit(SET_FORMAT,res.data);
            })
    },
    [SET_REPORT_FORMATS](context,payload) {
        axios.post("/reports/get-format",payload)
            .then(res => {
                context.commit(SET_REPORT_FORMAT,res.data);
                context.commit(SET_MONTH,payload.month);
                context.commit(SET_YEAR,payload.year);
            })
    },

};

const mutations = {
    [SET_FORMAT](state, data) {
        state.formats = data;
    },
    [SET_REPORT_FORMAT](state, data) {
        state.report_format = data;
    },
    [SET_MONTH](state, data) {
        state.month = data;
    },
    [SET_YEAR](state, data) {
       state.year = data;
    },
};

export default {
    state,
    actions,
    mutations,
    getters
};
