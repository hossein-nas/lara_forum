<template>
    <ul v-if="shouldPaginate" class="pagination">
        <li v-show="prevUrl">
            <a href="#"
               aria-label="Previous"
               rel="prev"
               @click.prevent="page--"
            >
                <span aria-hidden="true">&laquo; Previous</span>
            </a>
        </li>
        <!-- <li><a href="#">1</a></li> -->
        <li v-show="nextUrl">
            <a href="#"
               aria-label="Next"
               rel="next"
               @click.prevent="page++"
            >
                <span aria-hidden="true">Next &raquo;</span>
            </a>
        </li>
    </ul>
</template>

<script>

export default {
    name: "Paginator",

    props: ["dataSet"],

    data () {
        return {
            page: 1,
            prevUrl: false,
            nextUrl: false
        }
    },

    computed: {
        shouldPaginate () {
            return !!this.prevUrl || !!this.nextUrl
        }
    },

    watch: {
        dataSet () {
            this.page = this.dataSet.current_page
            this.prevUrl = this.dataSet.prev_page_url
            this.nextUrl = this.dataSet.next_page_url
        },

        page () {
            this.broadcast().updateUrl()
        }
    },

    methods: {
        broadcast () {
            this.$emit("updated", this.page)
            return this
        },

        updateUrl () {
            history.pushState(null, null, "?page=" + this.page)
        }
    }

}
</script>

<style>
</style>
