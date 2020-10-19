<template>
    <!-- prettier-ignore -->
    <form autocomplete="off" @submit.prevent="save">
        <b-field
            label="Question"
            label-for="text"
            :type="{ 'is-danger': hasError('text') }"
            :message="getError('text')"
        >
            <b-input
                id="text"
                placeholder="Question"
                v-model="form.text"
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
    name: 'QuestionForm',
})
export default class QuestionForm extends Mixins(formMixin) {
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

        this.$emit('save:question', {
            ...this.form,
        });
    }
}
</script>

<style scoped></style>
