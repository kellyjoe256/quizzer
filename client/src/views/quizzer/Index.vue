<template>
    <div class="taking-quiz">
        <section class="container">
            <div class="columns">
                <div class="column">
                    <!-- prettier-ignore -->
                    <div class="box content" v-if="show">
                        <template v-if="!questions.length">
                            <p>No questions available</p>
                        </template>
                        <template v-else-if="showResults">
                            <results
                                :answered-questions="answeredQuestions"
                            />
                        </template>
                        <template v-else>
                            <h1>{{ quiz.name }}</h1>
                            <p>{{ quiz.description }}</p>
                            <h4>Question {{ currentQuestionIndex }} of
                                {{ questions.length }}</h4>
                            <question-component
                                :question="currentQuestion"
                                @question:answered="answered"
                            />
                        </template>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import _ from 'lodash';
import { Answer, Question, Quiz } from '@/types';
import QuestionComponent from '@/views/quizzer/Question.vue';
import Results from '@/views/quizzer/Results.vue';

@Component({
    name: 'TakeQuiz',
    metaInfo: {
        title: 'Taking Quiz',
    },
    components: {
        Results,
        QuestionComponent,
    },
})
export default class TakeQuiz extends Vue {
    private show = false;

    private quiz: Quiz | null = null;

    private answeredQuestions: any[] = [];

    private currentQuestion: Question | null = null;

    private currentQuestionIndex = 1;

    private showResults = false;

    mounted() {
        const { params } = this.$route;

        const payload = {
            id: params.id,
            // eslint-disable-next-line @typescript-eslint/camelcase
            take_test: true,
        };

        this.$Progress.start();
        this.$store
            .dispatch('quizzes/takeQuiz', payload)
            .then((quiz) => {
                this.$Progress.finish();
                this.show = true;
                this.quiz = quiz;
            })
            .catch(() => this.$Progress.fail());
    }

    get questions(): Question[] {
        const { questions } = this.quiz;

        if (!questions || !questions.length) {
            return [];
        }

        const shuffledQuestions = _.shuffle(questions);
        const [firstQuestion] = shuffledQuestions;
        this.currentQuestion = firstQuestion;

        return shuffledQuestions;
    }

    answered(payload) {
        const [question, answer] = payload;
        this.storeAnswer(question, answer);
        this.setNextQuestion();
    }

    storeAnswer(question: Question, answer: Answer[] | Answer) {
        this.answeredQuestions.push({
            question,
            answer,
        });
    }

    setNextQuestion() {
        if (this.allQuestionsAnswered()) {
            this.showResults = true;
            return;
        }

        this.currentQuestionIndex += 1;
        this.currentQuestion = this.questions[this.currentQuestionIndex - 1];
    }

    allQuestionsAnswered(): boolean {
        return this.currentQuestionIndex === this.questions.length;
    }
}
</script>

<style scoped></style>
