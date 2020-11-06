<template>
    <div class="home">
        <section class="container">
            <div class="columns">
                <div class="column">
                    <!-- prettier-ignore -->
                    <div class="box content">
                        <div v-if="!quizzes.length">
                            <h1>No quizzes available</h1>
                        </div>
                        <div v-else>
                            <div
                                v-for="quiz in quizzes"
                                :key="quiz.id"
                                class="quiz"
                            >
                                <h1>{{ quiz.name }}</h1>
                                <p>{{ quiz.description }}</p>
                                <router-link
                                    :to="{
                                        name: 'take_quiz',
                                        params: {
                                            id: quiz.id,
                                        }
                                    }"
                                >Start Quiz</router-link>
                            </div>
                            <b-pagination
                                v-if="pagination.total && pagination.last_page > 1"
                                :total="pagination.total"
                                :per-page="pagination.per_page"
                                :current="pagination.current_page"
                                @change="changePage"
                                order="is-right"
                                aria-next-label="Next"
                                aria-previous-label="Previous"
                                aria-page-label="Page"
                                aria-current-label="Current page"
                                simple
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Pagination, Quiz } from '@/types';

@Component({
    name: 'Home',
    metaInfo: {
        title: 'Home',
    },
})
export default class Home extends Vue {
    get quizzes(): Quiz[] {
        return this.$store.getters['quizzes/quizzes'];
    }

    get pagination(): Pagination {
        return this.$store.getters.pagination;
    }

    changePage(page: number) {
        this.$router.replace({ query: { page } }).catch(console.log);
        this.getQuizzes(page);
    }

    getQuizzes(page = 0) {
        const { query } = this.$route;
        let payload = {};
        if (page) {
            payload = { ...query, page };
        }

        this.$store
            .dispatch('quizzes/get', payload)
            .then(() => {
                this.$Progress.finish();
            })
            .catch((e) => {
                console.log(e);
                this.$Progress.fail();
            });
    }

    mounted() {
        this.getQuizzes();
    }
}
</script>

<style lang="scss" scoped>
.quiz {
    margin-bottom: 2rem;

    p {
        margin-bottom: 1rem;
    }
}
</style>
