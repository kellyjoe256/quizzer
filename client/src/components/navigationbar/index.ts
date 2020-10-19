import { Component, Vue } from 'vue-property-decorator';
import WithRender from './template.html';

@WithRender
@Component({
    name: 'NavigationBar',
})
export default class NavigationBar extends Vue {
    get user() {
        return this.$store.getters['auth/user'];
    }

    get authenticated() {
        return this.$store.getters['auth/authenticated'];
    }

    private logout() {
        const name = 'login'; // route to go to after logging out

        this.$store
            .dispatch('auth/logout')
            .then(() => this.$router.replace({ name }))
            .catch((e) => {
                console.log(e);
                this.$router.replace({ name });
            });
    }
}
