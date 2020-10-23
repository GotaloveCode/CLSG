// action types
export const SET_ESSENTIALS = "setEssentials";
export const SET_CHECKLISTS = "setChecklists";


// mutation types
export const SET_ESSENTIAL = "setEssential";
export const SET_CUSTOMER = "setCustomer";
export const SET_STAFF = "setStaff";
export const SET_COMMUNICATION = "setCommunication";
export const SET_CHECKLIST = "setChecklist";
export const SET_MONTH = "setMonth";
export const SET_YEAR = "setYear";


const state = {
    essentials: {},
    customers: {},
    staffs: {},
    communications: {},
    checklist:{},
    month:'',
    year:'',
};

const getters = {
    getEssentials(state) {
      return state.essentials;
    },
    getCustomers(state) {
       return state.customers;
    },
    getStaffs(state) {
      return state.staffs;
    },
    getCommunications(state) {
      return state.communications;
    },
    getChecklist(state) {
      return state.checklist;
    },
    getMonth(state) {
      return state.month;
    },
    getYear(state) {
      return state.year;
    },
};

const actions = {
    [SET_ESSENTIALS](context,payload) {
        axios.get("/reports/checklist")
            .then(res => {
                context.commit(SET_ESSENTIAL,res.data.filter(e => e.type ==="Essential Operations"));
                context.commit(SET_CUSTOMER,res.data.filter(e => e.type ==="Vulnerable Customers"));
                context.commit(SET_STAFF,res.data.filter(e => e.type ==="Staff Health Protection"));
                context.commit(SET_COMMUNICATION,res.data.filter(e => e.type ==="Communication"));
            })
    },
    [SET_CHECKLISTS](context,payload) {
        axios.post("/reports/get-checklist",payload)
            .then(res => {
                console.log(res.data)
                context.commit(SET_CHECKLIST,res.data);
                context.commit(SET_MONTH,payload.month);
                context.commit(SET_YEAR,payload.year);
            })
    },

};

const mutations = {
    [SET_ESSENTIAL](state, data) {
        state.essentials = data;
    },
    [SET_CUSTOMER](state, data) {
        state.customers = data;
    },
    [SET_STAFF](state, data) {
        state.staffs = data;
    },
    [SET_COMMUNICATION](state, data) {
        state.communications = data;
    },
    [SET_CHECKLIST](state, data) {
        state.checklist = data;
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
