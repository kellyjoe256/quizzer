<template>
    <div class="quizzes">
        <section class="container">
            <div class="columns">
                <div class="column">
                    <!-- prettier-ignore -->
                    <div class="box content">
                        <h1>
                            Create Quiz
                            <router-link :to="{ name: 'quizzes' }">
                                Quizzes
                            </router-link>
                        </h1>

                        <quiz-form
                            :form-data="form"
                            :form-rules="rules"
                            @save:quiz="create"
                        />
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import QuizForm from '@/views/quizzes/Form.vue';
import { formData, formRules } from '@/views/quizzes/validation';

@Component({
    name: 'CreateQuiz',
    components: {
        QuizForm,
    },
    metaInfo: {
        title: 'Create Quiz',
    },
})
export default class CreateQuiz extends Vue {
    form = { ...formData };

    rules = formRules();

    create(payload) {
        this.$Progress.start();
        this.$store
            .dispatch('quizzes/save', payload)
            .then(() => {
                this.$Progress.finish();
                this.$router.replace({ name: 'quizzes' });
            })
            .catch(() => this.$Progress.fail());
    }
}
</script>

<style scoped></style>
