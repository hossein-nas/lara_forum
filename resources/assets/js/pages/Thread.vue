<script>
import replies from "../components/Replies.vue"
import SubscribeButton from "../components/SubscribeButton.vue"

export default {
    name: "Thread",

    components: {
        replies,
        SubscribeButton
    },

    props: ["thread"],

    data () {
        return {
            replies_count: this.thread.replies_count,
            locked: this.thread.locked
        }
    },

    computed: {
        repliesCount () {
            const count = this.replies_count
            const suffix = (count === 0 || count > 1) ? "comments" : "comment"

            return [count, suffix].join(" ")
        }
    },

    methods: {
        toggleLock () {
            this.locked = !this.locked
        }
    }
}
</script>

<style>
</style>
