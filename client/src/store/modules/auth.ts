/* eslint-disable @typescript-eslint/consistent-type-assertions */
import { ActionTree, GetterTree, MutationTree } from 'vuex';
import isEmpty from 'lodash/isEmpty';
import { User } from '@/types';
import http from '@/services/http';

class State {
    user: User = {};
}

const getters = <GetterTree<State, any>>{
    user(state): User {
        return state.user;
    },
    authenticated(state): boolean {
        return !isEmpty(state.user);
    },
};

const actions = <ActionTree<State, any>>{
    async login({ commit }, credentials) {
        const url = 'auth/login';
        const options = {
            headers: {
                'Content-Type': 'application/json',
            },
        };

        try {
            const { data: user } = await http.post(url, credentials, options);
            commit('SET_USER', user);

            return Promise.resolve(user);
        } catch (error) {
            return Promise.reject(error);
        }
    },

    async authenticate({ state, commit }) {
        if (!isEmpty(state.user)) {
            return;
        }

        const url = 'auth/me';
        try {
            const { data: user } = await http.get(url);

            commit('SET_USER', user);
        } catch (error) {
            commit('SET_USER', {});
        }
    },

    async logout({ commit }) {
        const url = 'auth/logout';

        try {
            await http.post(url);
            commit('SET_USER', {});

            return Promise.resolve();
        } catch (error) {
            commit('SET_USER', {});

            return Promise.reject(error);
        }
    },
};

const mutations = <MutationTree<State>>{
    SET_USER(state, payload) {
        state.user = payload;
    },
};

export default {
    namespaced: true,
    state: new State(),
    getters,
    actions,
    mutations,
};
