<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :reply="reply" @deleted="remove(index)"></reply>
        </div>

        <paginator :data-set="dataSet" @updated="fetch"></paginator>

        <new-reply :locked="locked" @created="add"></new-reply>
    </div>
</template>

<script>
import reply from "./Reply.vue"
import NewReply from "./NewReply"
import collection from "../mixins/collection"

export default {
    name: "Replies",

    components: {
        reply,
        NewReply
    },

    mixins: [collection],

    props: ["locked"],

    data () {
        return {
            dataSet: false,
            items: []
        }
    },

    created () {
        this.fetch()
    },

    methods: {

        fetch (page) {
            axios.get(this.url(page))
                .then(this.refresh)
        },

        refresh ({ data }) {
            this.dataSet = data
            this.items = data.data

            window.scrollTo(0, 0)
        },

        url (page) {
            if (!page) {
                const query = location.search.match(/page=(\d+)/)

                page = query ? query[1] : 1
            }
            return `${location.pathname}/replies?page=${page}`
        }

    }

}
</script>

<style>
</style>
