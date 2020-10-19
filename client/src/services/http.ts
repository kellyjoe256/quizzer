import axios from 'axios';

import store from '@/store';
import { BASE_URL } from '@/config';
import { getFirstError } from '@/utils';

interface HttpErrorMessage {
    type?: string;
    text?: string;
}

axios.defaults.baseURL = BASE_URL;
axios.defaults.headers.accept = 'application/json';
axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.withCredentials = true;

axios.interceptors.response.use(undefined, (error) => {
    const { response } = error;
    const { status: statusCode } = response;

    const rejectedPromise = Promise.reject(response);

    if (statusCode === 404 || statusCode > 499) {
        store.commit('SET_STATUS_CODE', statusCode, { root: true });

        return rejectedPromise;
    }

    const { data } = response;
    if (statusCode === 401 && data.message && data.message === 'Unauthenticated.') {
        store.commit('SET_STATUS_CODE', statusCode, { root: true });

        return rejectedPromise;
    }

    const message: HttpErrorMessage = { type: 'is-danger' };
    if (statusCode === 422) {
        message.text = getFirstError(data.errors);
        store.dispatch('flashMessage', message, { root: true });

        return rejectedPromise;
    }

    let text = data.error || data.message;
    if (!text || typeof text !== 'string') {
        text = response.statusText;
    }

    message.text = text;
    store.dispatch('flashMessage', message, { root: true });

    return rejectedPromise;
});

export default {
    get: axios.get,
    post: axios.post,
    put: axios.put,
    patch: axios.patch,
    delete: axios.delete,
    wrapper: axios,
};
