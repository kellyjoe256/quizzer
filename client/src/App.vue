<template>
    <div id="app">
        <vue-progress-bar></vue-progress-bar>
        <navigation-bar />
        <router-view />
    </div>
</template>

<script>
import { ToastProgrammatic as Toast } from 'buefy';

import NavigationBar from '@/components/navigationbar';

export default {
    name: 'App',
    components: {
        NavigationBar,
    },
    mounted() {
        this.$Progress.start();
        this.$router.beforeResolve((to, from, next) => {
            //  start the progress bar
            this.$Progress.start();
            next();
        });
        // eslint-disable-next-line no-unused-vars
        this.$router.afterEach((to, from) => {
            //  finish the progress bar
            this.$Progress.finish();
        });
    },
    watch: {
        '$store.state.message': function () {
            const { message } = this.$store.state;
            if (!message) {
                return;
            }

            const { type, text } = message;
            Toast.open({
                duration: 4500,
                message: text,
                type,
            });
        },
        '$store.state.statusCode': function () {
            const { statusCode } = this.$store.state;
            if (!statusCode) {
                return;
            }

            let routeName = 'not-found';
            if (statusCode === 401) {
                routeName = 'login';
            } else if (statusCode > 499) {
                routeName = 'error';
            }

            this.$store.commit('SET_STATUS_CODE', null, { root: true });
            this.$router.replace({ name: routeName }).catch(console.log);
        },
    },
};
</script>

<style lang="scss">
@import '~bulma';
@import '~buefy/src/scss/buefy';
@import './assets/css/main.scss';
</style>
