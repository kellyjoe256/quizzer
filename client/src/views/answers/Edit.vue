<template>
    <div class="answers">
        <section class="container">
            <div class="columns">
                <div class="column">
                    <!-- prettier-ignore -->
                    <div class="box content" v-if="showForm">
                        <h1>
                            Edit Answer
                            <span>
                                <router-link
                                    :to="{
                                        name: 'answers',
                                        query: {
                                            question_id: answer.question_id,
                                        },
                                    }"
                                >Answers</router-link>
                            </span>
                        </h1>

                        <answer-form
                            :form-data="form"
                            :form-rules="rules"
                            @save:answer="edit"
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
import { Answer } from '@/types';

@Component({
    name: 'EditAnswer',
    components: {
        AnswerForm,
    },
    metaInfo: {
        title: 'Edit Answer',
    },
})
export default class EditAnswer extends Vue {
    form = { ...formData };

    rules = formRules();

    showForm = false;

    answer: Answer = {};

    mounted() {
        const { params } = this.$route;

        this.$Progress.start();
        this.$store
            .dispatch('answers/getOne', params.id)
            .then((answer) => {
                this.$Progress.finish();
                this.showForm = true;
                this.form = { ...answer };
                this.answer = answer;
            })
            .catch(() => this.$Progress.fail());
    }

    /* eslint-disable @typescript-eslint/camelcase */
    edit(payload) {
        const { question_id } = this.answer;

        this.$Progress.start();
        this.$store
            .dispatch('answers/save', payload)
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
