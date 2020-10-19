<template>
    <div class="quizzes">
        <section class="container">
            <div class="columns">
                <div class="column">
                    <!-- prettier-ignore -->
                    <div class="box content">
                        <h1>
                            Edit Quiz
                            <span>
                                <router-link :to="{ name: 'quizzes' }">
                                    Quizzes
                                </router-link>
                            </span>
                        </h1>

                        <quiz-form
                            v-if="showForm"
                            :form-data="form"
                            :form-rules="rules"
                            @save:quiz="edit"
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
    name: 'EditQuiz',
    components: {
        QuizForm,
    },
    metaInfo: {
        title: 'Edit Quiz',
    },
})
export default class EditQuiz extends Vue {
    form = { ...formData };

    rules = formRules();

    showForm = false;

    mounted() {
        const { params } = this.$route;

        this.$Progress.start();
        this.$store
            .dispatch('quizzes/getOne', params.id)
            .then((quiz) => {
                this.$Progress.finish();
                this.showForm = true;
                this.form = { ...quiz };
            })
            .catch(() => this.$Progress.fail());
    }

    edit(payload) {
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
