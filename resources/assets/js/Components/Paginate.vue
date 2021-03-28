<template>
    <b-row>
        <b-col>
            <nav aria-label="Page Navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item" v-if="page.current > page.min">
                        <a
                            class="page-link"
                            href="#"
                            @click.prevent="handleClick(1)"
                            aria-label="First Page"
                        >
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item" v-if="page.current > 1">
                        <a
                            class="page-link"
                            href="#"
                            @click.prevent="handleClick(page.current - 1)"
                            aria-label="Previous Page"
                        >
                            <span aria-hidden="true">&lt;</span>
                        </a>
                    </li>
                    <li
                        v-for="p in page.range"
                        :key="`page${p}`"
                        class="page-item"
                        :class="{ active: page.current === p }"
                    >
                        <a class="page-link" href="#" @click.prevent="handleClick(p)">
                            {{ p }}
                        </a>
                    </li>
                    <li class="page-item" v-if="page.total > 1 && page.current < page.total">
                        <a
                            class="page-link"
                            href="#"
                            @click.prevent="handleClick(page.current + 1)"
                            aria-label="Next Page"
                        >
                            <span aria-hidden="true">&gt;</span>
                        </a>
                    </li>
                    <li class="page-item" v-if="page.max < page.total">
                        <a
                            class="page-link"
                            href="#"
                            @click.prevent="handleClick(page.total)"
                            aria-label="Last Page"
                        >
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </b-col>
    </b-row>
</template>

<script>
export default {
    name: 'Paginate',
    props: {
        currentPage: {
            default: 1,
            type: Number,
        },
        pageSize: {
            default: 15,
            type: Number,
        },
        maxPages: {
            default: 10,
            type: Number,
        },
        totalItems: {
            required: true,
            default: 0,
            type: Number,
        },
        isTwitch: {
            default: false,
            type: Boolean,
        },
    },
    data() {
        return {
            page: {
                total: 1,
                current: this.currentPage,
                min: 1,
                max: 1,
                range: [],
            },
        }
    },
    mounted() {
        this.calcPagination()
    },
    methods: {
        handleClick: function (page) {
            this.page.current = page

            this.$emit(
                'click',
                this.isTwitch ? (page === 1 ? 0 : this.pageSize * (page - 1)) : page,
            )
        },
        calcPagination: function () {
            this.page.total = Math.ceil(this.totalItems / this.pageSize)

            if (this.page.current < 1) {
                this.page.current = 1
            } else if (this.page.current > this.page.total) {
                this.page.current = this.page.total
            }

            if (this.page.total <= this.maxPages) {
                this.page.min = 1
                this.page.max = this.page.total
            } else {
                let maxPagesBeforeCurrentPage = Math.floor(this.maxPages / 2),
                    maxPagesAfterCurrentPage = Math.ceil(this.maxPages / 2) - 1

                if (this.currentPage <= maxPagesBeforeCurrentPage) {
                    this.page.min = 1
                    this.page.max = this.maxPages
                } else if (this.currentPage + maxPagesAfterCurrentPage >= this.page.total) {
                    this.page.min = this.page.total - this.maxPages + 1
                    this.page.max = this.maxPages
                } else {
                    this.page.min = this.currentPage - maxPagesBeforeCurrentPage
                    this.page.max = this.currentPage + maxPagesAfterCurrentPage
                }
            }

            this.page.range = Array.from(Array(this.page.max + 1 - this.page.min).keys()).map(
                (i) => this.page.min + i,
            )
        },
    },
}
</script>
