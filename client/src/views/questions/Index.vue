<template>
    <div class="questions">
        <section class="container">
            <div class="columns">
                <div class="column">
                    <div class="box content" v-if="show">
                        <!-- prettier-ignore -->
                        <h1>
                            {{ quiz.name }} Questions
                            <router-link
                                :to="{
                                    name: 'questions.create',
                                    query: {
                                        quiz_id: quiz.id,
                                    }
                                }"
                            >Create</router-link>
                        </h1>
                        <paginator :store-action="storeAction">
                            <b-table :data="questions" striped hoverable>
                                <template slot-scope="props">
                                    <b-table-column field="text" label="Question">
                                        {{ props.row.text }}
                                    </b-table-column>
                                    <b-table-column field="created_at" label="Created on">
                                        {{ props.row.created_at | datetime }}
                                    </b-table-column>
                                    <!-- prettier-ignore -->
                                    <b-table-column field="id">
                                        <a
                                            class="has-text-black"
                                            title="Answer"
                                            :href="`#${props.row.id}`"
                                        >Answers</a>
                                        |
                                        <router-link
                                            title="Edit"
                                            :to="{
                                                name: 'questions.edit',
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
import Vue from 'vue';
import { Component } from 'vue-property-decorator';
// import isEmpty from 'lodash/isEmpty';
import Paginator from '@/components/paginator';
import { Quiz } from '@/types';
import isEmpty from 'lodash/isEmpty';

@Component({
    metaInfo: {
        title: 'Questions',
    },
    components: {
        Paginator,
    },
})
export default class Questions extends Vue {
    show = false;

    quiz: Quiz = {};

    storeAction = 'questions/get';

    get questions() {
        return this.$store.getters['questions/questions'];
    }

    mounted() {
        const { query } = this.$route;
        const quizId = query.quiz_id || 0;

        this.$Progress.start();
        // check if quiz exists
        this.$store
            .dispatch('quizzes/getOne', quizId)
            .then((quiz) => {
                this.quiz = quiz;
                // fetch questions that belong to that particular quiz
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

        const { id: quiz_id } = this.quiz;

        this.$store
            .dispatch('questions/erase', { id, quiz_id })
            .then(() => {
                const { query } = this.$route;
                if (!isEmpty(query) && Object.keys(query).length > 1) {
                    this.$router
                        .replace({
                            query: { quiz_id },
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
