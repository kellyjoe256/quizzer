<template>
    <div class="login">
        <section class="container">
            <div class="columns is-multiline">
                <div class="column is-6 is-offset-3 login-form-area">
                    <div class="columns">
                        <div class="column form-area has-text-centered">
                            <h1 class="title is-4">Login</h1>
                            <p class="description">
                                Please login to proceed
                            </p>
                            <form @submit.prevent="onSubmit">
                                <div class="field">
                                    <div class="control">
                                        <input
                                            class="input is-medium"
                                            :class="{ 'is-danger': hasError('email') }"
                                            type="email"
                                            placeholder="Email Address"
                                            v-model="form.email"
                                        />
                                        <p class="help is-danger" v-if="hasError('email')">
                                            {{ getError('email') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <input
                                            class="input is-medium"
                                            :class="{ 'is-danger': hasError('password') }"
                                            :type="showPassword ? 'text' : 'password'"
                                            placeholder="Password"
                                            v-model="form.password"
                                        />
                                        <p class="help is-danger" v-if="hasError('password')">
                                            {{ getError('password') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="field">
                                    <b-checkbox v-model="showPassword">Show password</b-checkbox>
                                </div>
                                <button class="button is-block is-primary is-fullwidth is-medium">
                                    Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script lang="ts">
import { mapActions } from 'vuex';
import Joi from 'joi';
import formMixin from '@/mixins/formMixin';

export default formMixin.extend({
    name: 'Login',
    metaInfo: {
        title: 'Login',
    },
    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            rules: Joi.object({
                email: Joi.string().trim().required().messages({
                    'string.empty': 'Email is required',
                    'any.required': 'Email is required',
                }),
                password: Joi.string().trim().required().messages({
                    'string.empty': 'Password is required',
                    'any.required': 'Password is required',
                }),
            }),
            showPassword: false,
        };
    },
    methods: {
        ...mapActions({
            login: 'auth/login',
        }),
        onSubmit() {
            if (this.validate()) {
                return;
            }

            this.$Progress.start();
            this.login(this.form)
                .then(() => {
                    this.$Progress.finish();

                    this.$router.replace({ name: 'dashboard' });
                })
                .catch((error) => {
                    this.$Progress.fail();

                    console.log(error);
                });
        },
    },
});
</script>

<style lang="scss" scoped>
:root {
    --brandColor: hsl(166, 67%, 51%);
    --background: rgb(247, 247, 247);
    --textDark: hsla(0, 0%, 0%, 0.66);
    --textLight: hsla(0, 0%, 0%, 0.33);
}

.field:not(:last-child) {
    margin-bottom: 1rem;
}

.login-form-area {
    margin-top: 3rem;
    background: white;
    border-radius: 10px;
}

.form-area {
    padding: 1.5rem;

    .title {
        font-weight: 800;
        letter-spacing: -1px;
    }

    .description {
        margin-top: 1rem;
        margin-bottom: 2rem !important;
        color: var(--textLight);
        font-size: 1.15rem;
    }

    small {
        color: var(--textLight);
    }
}

input {
    font-size: 0.8rem;

    &:focus {
        border-color: var(--brandColor) !important;
        box-shadow: 0 0 0 1px var(--brandColor) !important;
    }
}
</style>
