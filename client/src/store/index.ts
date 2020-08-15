/* eslint-disable @typescript-eslint/consistent-type-assertions */
import Vue from 'vue';
import Vuex, { ActionTree, GetterTree, MutationTree } from 'vuex';
import modules from '@/store/modules';

Vue.use(Vuex);

class State {
    message = null;

    statusCode = null;
}

const getters = <GetterTree<State, any>>{
    message(state) {
        return state.message;
    },
};

const actions = <ActionTree<State, any>>{
    flashMessage({ commit }, message) {
        commit('SET_MESSAGE', message);

        setTimeout(() => {
            commit('SET_MESSAGE', null);
        }, 5000);
    },
};

const mutations = <MutationTree<State>>{
    SET_MESSAGE(state, message) {
        state.message = message;
    },

    SET_STATUS_CODE(state, statusCode) {
        state.statusCode = statusCode;
    },
};

export default new Vuex.Store({
    state: new State(),
    getters,
    actions,
    mutations,
    modules,
});
