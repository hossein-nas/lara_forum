<template>
    <div>
        <div v-for="(reply, index) in items" :key="index">
            <reply :attributes="reply" @deleted="remove(index)"></reply>
        </div>

        <new-reply @created="add"></new-reply>
    </div>
</template>

<script>
import reply from "./Reply.vue"
import NewReply from "./NewReply"

export default {
    name: "Replies",

    components: {
        reply,
        NewReply
    },

    props: ["data"],

    data () {
        return {
            items: this.data
        }
    },

    methods: {
        add (reply) {
            this.items.push(reply)

            this.$emit("added")
        },

        remove (index) {
            this.items.splice(index, 1)
            this.$emit("removed")

            flash("Reply was deleted!")
        }
    }

}
</script>

<style>
</style>
