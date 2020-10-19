<template>
    <div class="questions">
        <section class="container">
            <div class="columns">
                <div class="column">
                    <!-- prettier-ignore -->
                    <div class="box content">
                        <h1>
                            Create Question
                            <router-link
                                :to="{
                                    name: 'questions',
                                    query: {
                                        quiz_id: $route.query.quiz_id,
                                    }
                                }"
                            >Questions</router-link>
                        </h1>

                        <question-form
                            :form-data="form"
                            :form-rules="rules"
                            @save:question="create"
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

@Component({
    name: 'CreateQuestion',
    components: {
        QuestionForm,
    },
    metaInfo: {
        title: 'Create Question',
    },
})
export default class CreateQuestion extends Vue {
    form = { ...formData };

    rules = formRules();

    /* eslint-disable @typescript-eslint/camelcase */
    create(payload) {
        const { query } = this.$route;
        const { quiz_id } = query;

        this.$Progress.start();
        this.$store
            .dispatch('questions/save', { ...payload, quiz_id })
            .then(() => {
                this.$Progress.finish();
                this.$router.replace({
                    name: 'questions',
                    query: { quiz_id },
                });
            })
            .catch(() => this.$Progress.fail());
    }
}
</script>

<style scoped></style>
