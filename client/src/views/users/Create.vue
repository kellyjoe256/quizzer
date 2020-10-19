<template>
    <div class="users">
        <section class="container">
            <div class="columns">
                <div class="column">
                    <!-- prettier-ignore -->
                    <div class="box content">
                        <h1>
                            Create User
                            <span>
                                <router-link :to="{ name: 'users' }">
                                    Users
                                </router-link>
                            </span>
                        </h1>

                        <user-form
                            :form-data="form"
                            :form-rules="rules"
                            @save:user="create"
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
    name: 'CreateUser',
    components: {
        UserForm,
    },
    metaInfo: {
        title: 'Create User',
    },
})
export default class CreateUser extends Vue {
    form = { ...formData };

    rules = formRules();

    create(payload) {
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
