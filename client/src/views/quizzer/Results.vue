<template>
    <div class="results">
        <h2>Results</h2>
        <p>
            You got <strong>{{ correctAnswers }}</strong> out of
            <strong>{{ numberOfQuestions }}</strong>
        </p>
        <!-- prettier-ignore -->
        <div
            class="result"
            v-for="answeredQuestion in answeredQuestions"
            :key="answeredQuestion.question.id"
        >
            <h4>{{ answeredQuestion.question.text }}</h4>
            <p>
                Your answer:
                <span
                    :class="highlightClass(
                        answeredQuestion.answer,
                        answeredQuestion.question
                    )"
                >
                    {{ showChosenAnswer(answeredQuestion.answer) }}
                </span>
            </p>
            <p>Correct Answer: {{ showCorrectAnswers(answeredQuestion.question) }}</p>
        </div>
    </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import { Answer, Question } from '@/types';

/* eslint-disable class-methods-use-this */
@Component({
    name: 'Results',
})
export default class Results extends Vue {
    @Prop({ type: Array, required: true })
    private answeredQuestions;

    private separator = ' | ';

    showChosenAnswer(answer: Answer[] | Answer) {
        if (!Array.isArray(answer)) {
            return answer.value;
        }

        return answer.map((a) => a.value).join(this.separator);
    }

    showCorrectAnswers(question: Question) {
        return question.answers
            .filter((answer) => answer.is_true)
            .map((answer) => answer.value)
            .join(this.separator);
    }

    answerIsCorrect(answer: Answer[] | Answer, question: Question): boolean {
        if (!Array.isArray(answer)) {
            // @ts-expect-error
            return answer.is_true;
        }

        if (answer.some((a) => a.is_true === false)) {
            return false;
        }

        const numOfCorrectAnswers = question.answers.filter((a) => a.is_true).length;

        return numOfCorrectAnswers === answer.length;
    }

    highlightClass(answer: Answer[] | Answer, question: Question): string {
        const prefix = 'has-text';

        // prettier-ignore
        return this.answerIsCorrect(answer, question)
            ? `${prefix}-success`
            : `${prefix}-danger`;
    }

    get correctAnswers(): number {
        let count = 0;

        this.answeredQuestions.forEach((answeredQuestion) => {
            const { answer, question } = answeredQuestion;

            if (Array.isArray(answer) && this.answerIsCorrect(answer, question)) {
                count += 1;
            } else if (answer.is_true) {
                count += 1;
            }
        });

        return count;
    }

    get numberOfQuestions(): number {
        return this.answeredQuestions.length;
    }
}
</script>

<style scoped lang="scss">
.result {
    margin-bottom: 1.5rem;

    h4 {
        font-size: 1rem;
    }

    p {
        margin-bottom: 0.35em;
    }
}
</style>
