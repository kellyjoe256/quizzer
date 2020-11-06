<template>
    <!-- prettier-ignore -->
    <div class="answer">
        <label :for="`answer-${answer.id}`">
            <input
                :type="inputType"
                :id="`answer-${answer.id}`"
                :value="answer.id"
                :name="name"
                @change="chooseAnswer(answer)"
            > {{ answer.value }}
        </label>
    </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import { Answer } from '@/types';

@Component({
    name: 'Answer',
})
export default class AnswerComponent extends Vue {
    @Prop({ type: Object, required: true })
    private answer: Answer | undefined;

    @Prop({ type: Boolean, required: true })
    private useCheckBox;

    get name(): string {
        const name = 'answer';

        if (!this.useCheckBox) {
            return name;
        }

        return `${name}[]`;
    }

    get inputType(): string {
        return this.useCheckBox ? 'checkbox' : 'radio';
    }

    chooseAnswer(answer: Answer) {
        this.$emit('answer:chosen', answer);
    }
}
</script>

<style scoped></style>
