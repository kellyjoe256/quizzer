import _ from 'lodash';

export const is = (value) => ({}.toString.call(value).slice(8, -1).toLowerCase());

export const getFirstError = (errors: any) => {
    let error = errors.message;

    if (!_.isEmpty(errors)) {
        // eslint-disable-next-line
        for (const key of Object.keys(errors)) {
            const value = errors[key];

            if (is(value) === 'array') {
                error = value.length ? value[0] : error;
            } else {
                error = value;
            }

            break;
        }
    }

    return error;
};
