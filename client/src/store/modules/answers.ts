/* eslint-disable @typescript-eslint/consistent-type-assertions, @typescript-eslint/camelcase */
import { ActionTree, GetterTree, MutationTree } from 'vuex';
import _ from 'lodash';
import { PaginatorQuery, Answer } from '@/types';
import http from '@/services/http';

const baseURL = 'answers';

class State {
    answers: Answer[] = [];
}

const getters = <GetterTree<State, any>>{
    answers(state): Answer[] {
        return state.answers;
    },
};

const actions = <ActionTree<State, any>>{
    async get({ commit }, params: PaginatorQuery) {
        try {
            const { data } = await http.get(`${baseURL}`, {
                params,
            });
            const { data: answers, meta: paginationMeta } = data;
            commit('SET_ANSWERS', answers);
            commit('SET_PAGINATION', paginationMeta, { root: true });

            return Promise.resolve(answers);
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
        const fields = ['value', 'is_true', 'question_id'];

        try {
            const { data } = await http.wrapper({
                url,
                method,
                data: _.pick(payload, fields),
            });
            const message = {
                type: 'is-success',
                text: `Answer ${action}ed successfully`,
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
    async erase({ dispatch }, payload) {
        const { id, question_id } = payload;

        try {
            await http.delete(`${baseURL}/${id}`);

            const message = {
                type: 'is-success',
                text: 'Answer deleted successfully',
            };
            await dispatch('flashMessage', message, { root: true });
            await dispatch('get', { question_id }); // get the left over quizzes

            return Promise.resolve();
        } catch (error) {
            return Promise.reject(error);
        }
    },
};

const mutations = <MutationTree<State>>{
    SET_ANSWERS(state, payload) {
        state.answers = payload;
    },
};

export default {
    namespaced: true,
    state: new State(),
    getters,
    actions,
    mutations,
};
