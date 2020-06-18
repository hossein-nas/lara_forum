<template>
    <div>
        <div v-for="(reply, index) in items" :key="index">
            <reply :attributes="reply" @deleted="remove(index)"></reply>
        </div>
    </div>
</template>

<script>
import reply from "./Reply.vue"

export default {
    name: "Replies",

    components: {
        reply
    },

    props: ["data"],

    data () {
        return {
            items: this.data
        }
    },

    methods: {
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
