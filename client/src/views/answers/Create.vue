<template>
    <div class="questions">
        <section class="container">
            <div class="columns">
                <div class="column">
                    <!-- prettier-ignore -->
                    <div class="box content">
                        <h1>
                            Create Answer
                            <span>
                                <router-link
                                    :to="{
                                        name: 'answers',
                                        query: {
                                            question_id: $route.query.question_id,
                                        }
                                    }"
                                >Answers</router-link>
                            </span>
                        </h1>

                        <answer-form
                            :form-data="form"
                            :form-rules="rules"
                            @save:answer="create"
                        />
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import AnswerForm from '@/views/answers/Form.vue';
import { formData, formRules } from '@/views/answers/validation';

@Component({
    name: 'CreateAnswer',
    components: {
        AnswerForm,
    },
    metaInfo: {
        title: 'Create Answer',
    },
})
export default class CreateAnswer extends Vue {
    form = { ...formData };

    rules = formRules();

    /* eslint-disable @typescript-eslint/camelcase, consistent-return */
    create(payload) {
        const { query } = this.$route;
        const { question_id } = query;

        if (!question_id) {
            return this.$router.replace({ name: 'quizzes' });
        }

        this.$Progress.start();
        this.$store
            .dispatch('answers/save', { ...payload, question_id })
            .then(() => {
                this.$Progress.finish();
                this.$router.replace({
                    name: 'answers',
                    query: { question_id },
                });
            })
            .catch(() => this.$Progress.fail());
    }
}
</script>

<style scoped></style>
