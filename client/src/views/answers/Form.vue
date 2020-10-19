<template>
    <!-- prettier-ignore -->
    <form autocomplete="off" @submit.prevent="save">
        <b-field
            label="Answer"
            label-for="value"
            :type="{ 'is-danger': hasError('value') }"
            :message="getError('value')"
        >
            <b-input
                id="value"
                placeholder="Answer"
                v-model="form.value"
            />
        </b-field>
        <div class="field">
            <b-checkbox v-model="form.is_true">Is correct?</b-checkbox>
        </div>
        <button class="button is-block is-primary is-fullwidth is-medium">
            {{ buttonText }}
        </button>
    </form>
</template>

<script lang="ts">
import { Component, Mixins, Prop } from 'vue-property-decorator';
import formMixin from '@/mixins/formMixin';

@Component({
    name: 'AnswerForm',
})
export default class AnswerForm extends Mixins(formMixin) {
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

        this.$emit('save:answer', {
            ...this.form,
        });
    }
}
</script>

<style scoped>
.field:last-child {
    margin-top: 1.2rem;
}
</style>
