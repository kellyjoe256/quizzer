<template>
    <div class="users">
        <section class="container">
            <div class="columns">
                <div class="column">
                    <!-- prettier-ignore -->
                    <div class="box content">
                        <h1>
                            Edit User
                            <span>
                                <router-link :to="{ name: 'users' }">
                                    Users
                                </router-link>
                            </span>
                        </h1>

                        <user-form
                            v-if="showForm"
                            :form-data="form"
                            :form-rules="rules"
                            @save:user="edit"
                        />
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import UserForm from '@/views/users/Form.vue';
import { formData, formRules } from '@/views/users/validation';

@Component({
    name: 'EditUser',
    components: {
        UserForm,
    },
    metaInfo: {
        title: 'Edit User',
    },
})
export default class EditUser extends Vue {
    form = { ...formData };

    rules = formRules();

    showForm = false;

    mounted() {
        const { params } = this.$route;

        this.$Progress.start();
        this.$store
            .dispatch('users/getOne', params.id)
            .then((user) => {
                this.$Progress.finish();
                this.showForm = true;
                this.form = { ...user };
            })
            .catch(() => this.$Progress.fail());
    }

    edit(payload) {
        this.$Progress.start();
        this.$store
            .dispatch('users/save', payload)
            .then(() => {
                this.$Progress.finish();
                this.$router.replace({ name: 'users' });
            })
            .catch(() => this.$Progress.fail());
    }
}
</script>

<style scoped></style>
