<template>
    <!-- prettier-ignore -->
    <form autocomplete="off" @submit.prevent="save">
        <b-field
            label="Name"
            label-for="name"
            :type="{ 'is-danger': hasError('name') }"
            :message="getError('name')"
        >
            <b-input
                id="name"
                placeholder="Name"
                v-model="form.name"
            />
        </b-field>

        <b-field
            label="Email"
            label-for="email"
            :type="{ 'is-danger': hasError('email') }"
            :message="getError('email')"
        >
            <b-input
                id="email"
                type="email"
                placeholder="Email"
                autocomplete="off"
                v-model="form.email"
            />
        </b-field>

        <button class="button is-block is-primary is-fullwidth is-medium">
            {{ buttonText }}
        </button>
    </form>
</template>

<script lang="ts">
import { Component, Mixins, Prop } from 'vue-property-decorator';
import formMixin from '@/mixins/formMixin';

@Component({
    name: 'UserForm',
})
export default class UserForm extends Mixins(formMixin) {
    @Prop({ type: Object, required: true })
    private formData;

    @Prop({ type: Object, required: true })
    private formRules;

    mounted() {
        this.form = this.formData;
        this.rules = this.formRules;
    }

    get buttonText() {
        const { id } = this.formData;

        return id ? 'Edit' : 'Create';
    }

    save() {
        if (this.validate()) {
            return;
        }

        this.$emit('save:user', {
            ...this.form,
        });
    }
}
</script>

<style scoped></style>
