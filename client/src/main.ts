import Vue from 'vue';
import VueMeta from 'vue-meta';
import VueProgressBar from 'vue-progressbar';
import Buefy from 'buefy';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import filters from '@/mixins/filters';
import App from './App.vue';
import router from './router';
import store from './store';

Vue.use(VueMeta, {
    refreshOnceOnNavigation: true,
});
Vue.use(VueProgressBar, {
    color: '#434343',
    failedColor: '#dd4b39',
    thickness: '5px',
    transition: {
        speed: '1s',
        opacity: '0.9s',
        termination: 600,
    },
    autoRevert: true,
    location: 'top',
    inverse: false,
});
// Buefy
library.add(fas);
Vue.component('vue-fontawesome', FontAwesomeIcon);
Vue.use(Buefy, {
    defaultIconComponent: 'vue-fontawesome',
    defaultIconPack: 'fas',
    customIconPacks: {
        fas: {
            sizes: {
                default: 'lg',
                'is-small': '1x',
                'is-medium': '2x',
                'is-large': '3x',
            },
            iconPrefix: '',
        },
    },
});
Vue.mixin({
    filters,
});

Vue.config.productionTip = false;

store.dispatch('auth/authenticate').then(() => {
    new Vue({
        router,
        store,
        render: (h) => h(App),
    }).$mount('#app');
});
