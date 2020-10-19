/* eslint-disable @typescript-eslint/consistent-type-assertions, @typescript-eslint/camelcase */
import { ActionTree, GetterTree, MutationTree } from 'vuex';
import _ from 'lodash';
import { PaginatorQuery, Question } from '@/types';
import http from '@/services/http';

const baseURL = 'questions';

class State {
    questions: Question[] = [];
}

const getters = <GetterTree<State, any>>{
    questions(state): Question[] {
        return state.questions;
    },
};

const actions = <ActionTree<State, any>>{
    async get({ commit }, params: PaginatorQuery) {
        try {
            const { data } = await http.get(`${baseURL}`, {
                params,
            });
            const { data: questions, meta: paginationMeta } = data;
            commit('SET_QUESTIONS', questions);
            commit('SET_PAGINATION', paginationMeta, { root: true });

            return Promise.resolve(questions);
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
        const fields = ['text', 'quiz_id'];

        try {
            const { data } = await http.wrapper({
                url,
                method,
                data: _.pick(payload, fields),
            });
            const message = {
                type: 'is-success',
                text: `Question ${action}ed successfully`,
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
        const { id, quiz_id } = payload;

        try {
            await http.delete(`${baseURL}/${id}`);

            const message = {
                type: 'is-success',
                text: 'Question deleted successfully',
            };
            await dispatch('flashMessage', message, { root: true });
            await dispatch('get', { quiz_id }); // get the left over quizzes

            return Promise.resolve();
        } catch (error) {
            return Promise.reject(error);
        }
    },
};

const mutations = <MutationTree<State>>{
    SET_QUESTIONS(state, payload) {
        state.questions = payload;
    },
};

export default {
    namespaced: true,
    state: new State(),
    getters,
    actions,
    mutations,
};
