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
            label="Description"
            label-for="description"
            :type="{ 'is-danger': hasError('description') }"
            :message="getError('description')"
        >
            <b-input
                type="textarea"
                id="description"
                placeholder="Description"
                v-model="form.description"
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
    name: 'QuizForm',
})
export default class QuizForm extends Mixins(formMixin) {
    @Prop({ type: Object, required: true })
    private formData;

    @Prop({ type: Object, required: true })
    private formRules;

    mounted() {
        this.form = this.formData;
        this.rules = this.formRules;
    }

    get user() {
        return this.$store.getters['auth/user'];
    }

    get buttonText() {
        const { id } = this.formData;

        return id ? 'Edit' : 'Create';
    }

    save() {
        if (this.validate()) {
            return;
        }

        this.$emit('save:quizzer', {
            ...this.form,
            // eslint-disable-next-line
            user_id: this.user.id,
        });
    }
}
</script>

<style scoped></style>
