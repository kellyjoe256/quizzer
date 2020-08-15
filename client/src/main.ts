import Vue from 'vue';
import VueMeta from 'vue-meta';
import VueProgressBar from 'vue-progressbar';
import Buefy from 'buefy';
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
Vue.use(Buefy, {
    defaultIconPack: 'fas',
});

Vue.config.productionTip = false;

store.dispatch('auth/authenticate').then(() => {
    new Vue({
        router,
        store,
        render: (h) => h(App),
    }).$mount('#app');
});
