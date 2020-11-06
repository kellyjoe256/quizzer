<template>
    <div class="quizzes">
        <section class="container">
            <div class="columns">
                <div class="column">
                    <!-- prettier-ignore -->
                    <div class="box content" v-if="showForm">
                        <h1>
                            Edit Question
                            <span>
                                <router-link
                                    :to="{
                                        name: 'questions',
                                        query: {
                                            quiz_id: question.quiz_id,
                                        },
                                    }"
                                >Questions</router-link>
                            </span>
                        </h1>

                        <question-form
                            :form-data="form"
                            :form-rules="rules"
                            @save:question="edit"
                        />
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import QuestionForm from '@/views/questions/Form.vue';
import { formData, formRules } from '@/views/questions/validation';
import { Question } from '@/types';

@Component({
    name: 'EditQuestion',
    components: {
        QuestionForm,
    },
    metaInfo: {
        title: 'Edit Question',
    },
})
export default class EditQuestion extends Vue {
    form = { ...formData };

    rules = formRules();

    showForm = false;

    question: Question = {};

    mounted() {
        const { params } = this.$route;

        this.$Progress.start();
        this.$store
            .dispatch('questions/getOne', params.id)
            .then((question) => {
                this.$Progress.finish();
                this.showForm = true;
                this.form = { ...question };
                this.question = question;
            })
            .catch(() => this.$Progress.fail());
    }

    /* eslint-disable @typescript-eslint/camelcase */
    edit(payload) {
        const { quiz_id } = this.question;

        this.$Progress.start();
        this.$store
            .dispatch('questions/save', payload)
            .then(() => {
                this.$Progress.finish();
                this.$router.replace({
                    name: 'questions',
                    // @ts-expect-error
                    query: { quiz_id },
                });
            })
            .catch(() => this.$Progress.fail());
    }
}
</script>

<style scoped></style>
