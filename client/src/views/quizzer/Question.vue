<template>
    <div class="question">
        <h4>{{ question.text }}</h4>
        <answer-component
            v-for="answer in question.answers"
            :key="answer.id"
            :answer="answer"
            :use-check-box="useCheckboxes"
            @answer:chosen="saveAnswer"
        />

        <!-- prettier-ignore -->
        <b-button
            v-if="showNext"
            class="mt-3 is-success"
            @click.prevent="goToNextQuestion"
        >Next
        </b-button>
    </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import _ from 'lodash';
import { Answer, Question } from '@/types';
import AnswerComponent from '@/views/quizzer/Answer.vue';

@Component({
    name: 'Question',
    components: {
        AnswerComponent,
    },
})
export default class QuestionComponent extends Vue {
    @Prop({ type: Object, required: true })
    private question: Question | undefined;

    private showNext = false;

    private answerChosen: Answer[] | Answer = {};

    get useCheckboxes(): boolean {
        if (!(this.question && Object.keys(this.question).includes('answers'))) {
            return false;
        }

        const { answers } = this.question;
        const usingCheckBox = answers.filter((answer) => answer.is_true).length > 1;

        if (usingCheckBox) {
            this.answerChosen = [];
        }

        return usingCheckBox;
    }

    answerHasBeenChosen(): boolean {
        if (Array.isArray(this.answerChosen)) {
            return Boolean(this.answerChosen.length);
        }

        return !_.isEmpty(this.answerChosen);
    }

    saveAnswer(answer: Answer) {
        if (!this.useCheckboxes) {
            this.answerChosen = answer;
        } else {
            this.toggleAnswer(answer);
        }

        this.showNext = this.answerHasBeenChosen();
    }

    toggleAnswer(answer: Answer) {
        const exists = this.answerChosen.find((a) => a.id === answer.id);
        // if it exists, remove it
        if (exists) {
            this.answerChosen = this.answerChosen.filter((a) => a.id !== answer.id);
            return;
        }
        // if it does not exist, add it
        this.answerChosen.push(answer);
    }

    goToNextQuestion() {
        this.showNext = false;
        this.$emit('question:answered', [this.question, this.answerChosen]);
    }
}
</script>

<style scoped>
h4 {
    font-size: 1rem;
}
</style>
