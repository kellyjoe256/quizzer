import _ from 'lodash';
import moment from 'moment';

export default {
    date(value) {
        if (!value || !moment(value).isValid()) {
            return value;
        }

        return moment(value).format('MMMM Do, YYYY');
    },
    datetime(value) {
        if (!value || !moment(value).isValid()) {
            return value;
        }

        return moment(value).format('MMMM Do, YYYY h:mm A');
    },
    pick(value, paths) {
        if (!value || !(_.isObject(value) && !_.isEmpty(value))) {
            return value;
        }

        return _.pick(value, paths);
    },
};
