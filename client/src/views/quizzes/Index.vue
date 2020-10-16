<template>
    <div class="quizzes">
        <section class="container">
            <div class="columns">
                <div class="column">
                    <div class="box content" v-if="show">
                        <!-- prettier-ignore -->
                        <h1>
                            Quizzes
                            <router-link :to="{ name: 'quizzes.create' }">
                                Create
                            </router-link>
                        </h1>
                        <paginator :store-action="storeAction">
                            <b-table :data="quizzes" striped hoverable>
                                <template slot-scope="props">
                                    <b-table-column field="name" label="Name">
                                        {{ props.row.name }}
                                    </b-table-column>
                                    <b-table-column field="description" label="Description">
                                        {{ props.row.description }}
                                    </b-table-column>
                                    <b-table-column field="created_at" label="Created on">
                                        {{ props.row.created_at | datetime }}
                                    </b-table-column>
                                    <b-table-column
                                        v-if="user.is_admin"
                                        field="user"
                                        label="Created by"
                                    >
                                        {{ props.row.user ? props.row.user.email : '' }}
                                    </b-table-column>
                                    <!-- prettier-ignore -->
                                    <b-table-column field="id">
                                        <a
                                            class="has-text-black"
                                            :title="`${props.row.name} Questions`"
                                            :href="`#${props.row.id}`"
                                        >Questions</a>
                                        |
                                        <router-link
                                            title="Edit"
                                            :to="{
                                                name: 'quizzes.edit',
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
import isEmpty from 'lodash/isEmpty';
import Paginator from '@/components/paginator';

@Component({
    metaInfo: {
        title: 'Quizzes',
    },
    components: {
        Paginator,
    },
})
export default class Quizzes extends Vue {
    show = false;

    storeAction = 'quizzes/get';

    get user() {
        return this.$store.getters['auth/user'];
    }

    get pagination() {
        return this.$store.getters.pagination;
    }

    get quizzes() {
        return this.$store.getters['quizzes/quizzes'];
    }

    mounted() {
        this.$Progress.start();

        this.$store
            .dispatch(this.storeAction, this.$route.query)
            .then(() => {
                this.show = true;
                this.$Progress.finish();
            })
            .catch((e) => {
                console.log(e);
                this.$Progress.fail();
            });
    }

    erase(id: number) {
        // eslint-disable-next-line
        if (!confirm('Are you sure?')) {
            return;
        }

        this.$store
            .dispatch('quizzes/erase', id)
            .then(() => {
                if (!isEmpty(this.$route.query)) {
                    this.$router.replace({ query: {} }).catch(console.log);
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
