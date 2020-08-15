import { Component, Vue } from 'vue-property-decorator';
import { mapGetters } from 'vuex';
import WithRender from './template.html';

@WithRender
@Component({
    computed: {
        ...mapGetters({
            user: 'auth/user',
            authenticated: 'auth/authenticated',
        }),
    },
})
export default class NavigationBar extends Vue {
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
