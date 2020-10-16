import { Component, Prop, Vue } from 'vue-property-decorator';
import { Pagination, PaginatorQuery } from '@/types';
import WithRender from './template.html';

@WithRender
@Component({})
export default class Paginator extends Vue {
    @Prop({ type: String, required: true })
    private storeAction;

    get pagination(): Pagination {
        return this.$store.getters.pagination;
    }

    private query(page: number, limit: number): PaginatorQuery {
        return {
            ...this.$route.query,
            page,
            limit,
        };
    }

    private fetch(query: PaginatorQuery) {
        this.$Progress.start();

        this.$store
            .dispatch(this.storeAction, query)
            .then(() => this.$Progress.finish())
            .catch((e) => {
                console.log(e);
                this.$Progress.fail();
            });
    }

    private changePage(page: number) {
        let { per_page: limit } = this.pagination;
        limit = limit || 10;
        const query = this.query(page, limit);
        this.$router.replace({ query }).catch(console.log);
        this.fetch(query);
    }

    private changeLimit(limit: number) {
        const query = this.query(1, limit);
        this.$router.replace({ query }).catch(console.log);
        this.fetch(query);
    }
}
