<script>
import replies from "../components/Replies.vue"

export default {
    name: "Thread",

    components: {
        replies
    },

    props: ["initialRepliesCount"],

    data () {
        return {
            replies_count: this.initialRepliesCount
        }
    },

    computed: {
        repliesCount () {
            const count = this.replies_count
            const suffix = (count === 0 || count > 1) ? "comments" : "comment"

            return [count, suffix].join(" ")
        }
    }

}
</script>

<style>
</style>
