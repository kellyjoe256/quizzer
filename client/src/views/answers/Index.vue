<template>
    <div class="answers">
        <section class="container">
            <div class="columns">
                <div class="column">
                    <div class="box content" v-if="show">
                        <!-- prettier-ignore -->
                        <h1>
                            {{ question.text }} Answers
                            <span>
                                <router-link
                                    :to="{
                                        name: 'questions',
                                        query: {
                                            quiz_id: question.quiz_id,
                                        }
                                    }"
                                >Questions</router-link>
                                |
                                <router-link
                                    :to="{
                                        name: 'answers.create',
                                        query: {
                                            question_id: question.id,
                                        }
                                    }"
                                >Create</router-link>
                            </span>
                        </h1>
                        <paginator :store-action="storeAction">
                            <b-table :data="answers" striped hoverable>
                                <template slot-scope="props">
                                    <b-table-column field="value" label="Answer">
                                        {{ props.row.value }}
                                    </b-table-column>
                                    <b-table-column field="is_true" label="Is correct?">
                                        {{ props.row.is_true ? 'True' : 'False' }}
                                    </b-table-column>
                                    <b-table-column field="created_at" label="Created on">
                                        {{ props.row.created_at | datetime }}
                                    </b-table-column>
                                    <!-- prettier-ignore -->
                                    <b-table-column field="id">
                                        <router-link
                                            title="Edit"
                                            :to="{
                                                name: 'answers.edit',
                                                params: {
                                                    id: props.row.id,
                                                }
                                            }"
                                        >Edit</router-link>
                                        |
                                        <a
                                            title="Delete"
                                            class="has-text-danger"
                                            href="#"
                                            @click.prevent="erase(props.row.id)"
                                        >Delete</a>
                                    </b-table-column>
                                </template>
                            </b-table>
                        </paginator>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import isEmpty from 'lodash/isEmpty';
import Paginator from '@/components/paginator';
import { Question } from '@/types';

@Component({
    metaInfo: {
        title: 'Answers',
    },
    components: {
        Paginator,
    },
})
export default class Answers extends Vue {
    show = false;

    question: Question = {};

    storeAction = 'answers/get';

    get answers() {
        return this.$store.getters['answers/answers'];
    }

    mounted() {
        const { query } = this.$route;
        const questionId = Number(query.question_id) || 0;

        this.$Progress.start();
        // check if quizzer exists
        this.$store
            .dispatch('questions/getOne', questionId)
            .then((question) => {
                this.question = question;
                // fetch answers that belong to that particular quizzer
                this.$store
                    .dispatch(this.storeAction, query)
                    .then(() => {
                        this.show = true;
                        this.$Progress.finish();
                    })
                    .catch(console.log);
            })
            .catch((e) => {
                console.log(e);
                this.$Progress.fail();
            });
    }

    /* eslint-disable @typescript-eslint/camelcase */
    erase(id) {
        // eslint-disable-next-line
        if (!confirm('Are you sure?')) {
            return;
        }

        const { id: question_id } = this.question;

        this.$store
            .dispatch('answers/erase', { id, question_id })
            .then(() => {
                const { query } = this.$route;
                if (!isEmpty(query) && Object.keys(query).length > 1) {
                    this.$router
                        .replace({
                            query: { question_id },
                        })
                        .catch(console.log);
                }
                this.$Progress.finish();
            })
            .catch((e) => {
                console.log(e);
                this.$Progress.fail();
            });
    }
}
</script>

<style scoped></style>
