<template>
    <div class="users">
        <section class="container">
            <div class="columns">
                <div class="column">
                    <div class="box content" v-if="show">
                        <!-- prettier-ignore -->
                        <h1>
                            Users
                            <span>
                                <a href="#" @click.prevent="showMessage">Create</a>
                                <!-- <router-link :to="{ name: 'users.create' }">
                                    Create
                                </router-link> -->
                            </span>
                        </h1>
                        <paginator :store-action="storeAction">
                            <b-table :data="users" striped hoverable>
                                <template slot-scope="props">
                                    <b-table-column field="email" label="Email">
                                        {{ props.row.email }}
                                    </b-table-column>
                                    <b-table-column field="name" label="Name">
                                        {{ props.row.name }}
                                    </b-table-column>
                                    <b-table-column field="is_admin" label="Is admin?">
                                        {{ props.row.is_admin ? 'True' : 'False' }}
                                    </b-table-column>
                                    <b-table-column field="created_at" label="Created on">
                                        {{ props.row.created_at | datetime }}
                                    </b-table-column>
                                    <!-- prettier-ignore -->
                                    <b-table-column field="id">
                                        <a
                                            :href="`#${props.row.id}`"
                                            @click.prevent="showMessage"
                                        >Edit</a>
                                        <!-- <router-link
                                            title="Edit"
                                            :to="{
                                                name: 'users.edit',
                                                params: {
                                                    id: props.row.id,
                                                }
                                            }"
                                        >Edit</router-link> -->
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
import { ToastProgrammatic as Toast } from 'buefy';
import isEmpty from 'lodash/isEmpty';
import Paginator from '@/components/paginator';

@Component({
    name: 'Users',
    metaInfo: {
        title: 'Users',
    },
    components: {
        Paginator,
    },
})
export default class Users extends Vue {
    show = false;

    storeAction = 'users/get';

    get users() {
        return this.$store.getters['users/users'];
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

    /* eslint-disable class-methods-use-this */
    toast(message: string, type: string, duration = 4500) {
        Toast.open({
            duration,
            message,
            type,
        });
    }

    erase(id: number) {
        // eslint-disable-next-line
        if (!confirm('Are you sure?')) {
            return;
        }

        this.toast('Deletion of users is disabled', 'is-info');
        console.log('Cannot delete users', id, this.show);
        // this.$store
        //     .dispatch('users/erase', id)
        //     .then(() => {
        //         if (!isEmpty(this.$route.query)) {
        //             this.$router.replace({ query: {} }).catch(console.log);
        //         }
        //         this.$Progress.finish();
        //     })
        //     .catch((e) => {
        //         console.log(e);
        //         this.$Progress.fail();
        //     });
    }

    showMessage() {
        this.toast('Creating and editing of users is disabled', 'is-info');
        console.log(this.show);
    }
}
</script>

<style scoped></style>
