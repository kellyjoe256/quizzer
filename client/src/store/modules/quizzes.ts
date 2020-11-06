/* eslint-disable @typescript-eslint/consistent-type-assertions */
import { ActionTree, GetterTree, MutationTree } from 'vuex';
import _ from 'lodash';
import { PaginatorQuery, Quiz } from '@/types';
import http from '@/services/http';

const baseURL = 'quizzes';

class State {
    quizzes: Quiz[] = [];
}

const getters = <GetterTree<State, any>>{
    quizzes(state): Quiz[] {
        return state.quizzes;
    },
};

const actions = <ActionTree<State, any>>{
    async get({ commit }, params: PaginatorQuery) {
        try {
            const { data } = await http.get(`${baseURL}`, {
                params,
            });
            const { data: quizzes, meta: paginationMeta } = data;
            commit('SET_QUIZZES', quizzes);
            commit('SET_PAGINATION', paginationMeta, { root: true });

            return Promise.resolve(quizzes);
        } catch (error) {
            return Promise.reject(error);
        }
    },
    async save({ dispatch }, payload) {
        const { id } = payload;
        const action = id ? 'edit' : 'creat';
        const method = id ? 'PUT' : 'POST';
        const url = id ? `${baseURL}/${id}` : baseURL;
        // prettier-ignore
        const fields = ['name', 'description', 'user_id'];

        try {
            const { data } = await http.wrapper({
                url,
                method,
                data: _.pick(payload, fields),
            });
            const message = {
                type: 'is-success',
                text: `Quiz ${action}ed successfully`,
            };
            await dispatch('flashMessage', message, { root: true });

            return Promise.resolve(data);
        } catch (error) {
            return Promise.reject(error);
        }
    },
    async getOne({ commit }, id: number) {
        const url = `${baseURL}/${id}`;

        try {
            const { data } = await http.get(url);

            return Promise.resolve(data.data);
        } catch (error) {
            return Promise.reject(error);
        }
    },
    async takeQuiz({ commit }, params) {
        const { id, ...rest } = params;
        const url = `${baseURL}/${id}`;

        try {
            const { data } = await http.get(url, {
                params: { ...rest },
            });

            return Promise.resolve(data.data);
        } catch (error) {
            return Promise.reject(error);
        }
    },
    async erase({ dispatch }, id: number) {
        try {
            await http.delete(`${baseURL}/${id}`);

            const message = {
                type: 'is-success',
                text: 'Quiz deleted successfully',
            };
            await dispatch('flashMessage', message, { root: true });
            await dispatch('get', {}); // get the left over quizzes

            return Promise.resolve();
        } catch (error) {
            return Promise.reject(error);
        }
    },
};

const mutations = <MutationTree<State>>{
    SET_QUIZZES(state, payload) {
        state.quizzes = payload;
    },
};

export default {
    namespaced: true,
    state: new State(),
    getters,
    actions,
    mutations,
};
