/* eslint-disable @typescript-eslint/consistent-type-assertions */
import { ActionTree, GetterTree, MutationTree } from 'vuex';
import _ from 'lodash';
import { PaginatorQuery, User } from '@/types';
import http from '@/services/http';

const baseURL = 'users';

class State {
    users: User[] = [];
}

const getters = <GetterTree<State, any>>{
    users(state): User[] {
        return state.users;
    },
};

const actions = <ActionTree<State, any>>{
    async get({ commit }, params: PaginatorQuery) {
        try {
            const { data } = await http.get(`${baseURL}`, {
                params,
            });
            const { data: users, meta: paginationMeta } = data;
            commit('SET_USERS', users);
            commit('SET_PAGINATION', paginationMeta, { root: true });

            return Promise.resolve(users);
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
        const fields = ['name', 'email', 'password', 'is_admin'];

        try {
            const { data } = await http.wrapper({
                url,
                method,
                data: _.pick(payload, fields),
            });
            const message = {
                type: 'is-success',
                text: `User ${action}ed successfully`,
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
    async erase({ dispatch }, id: number) {
        try {
            await http.delete(`${baseURL}/${id}`);

            const message = {
                type: 'is-success',
                text: 'User deleted successfully',
            };
            await dispatch('flashMessage', message, { root: true });
            await dispatch('get', {}); // get the left over users

            return Promise.resolve();
        } catch (error) {
            return Promise.reject(error);
        }
    },
};

const mutations = <MutationTree<State>>{
    SET_USERS(state, payload) {
        state.users = payload;
    },
};

export default {
    namespaced: true,
    state: new State(),
    getters,
    actions,
    mutations,
};
