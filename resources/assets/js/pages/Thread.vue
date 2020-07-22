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
            locked: this.thread.locked,
            editing: false,
            form: {
                title: this.thread.title,
                body: this.thread.body
            }
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
            let uri = `/threads/${this.thread.slug}/lock`
            axios[this.locked ? "delete" : "post"](uri)
                .then((res) => {
                    this.locked = !this.locked

                    flash(
                        "The thread " + (this.locked ? "Locked" : "Unlocked") +
                        " Successfully.", (this.locked ? "danger" : "success")
                    )
                })
        },

        resetForm () {
            this.editing = false

            this.form = {
                title: this.thread.title,
                body: this.thread.body
            }
        },

        stopEditing () {
            this.editing = false
        },

        update () {
            let uri = `/threads/${this.thread.channel.slug}/${this.thread.slug}`
            axios.patch(uri, this.form)
                .then(() => {
                    this.stopEditing()

                    flash("Your thread has been updated.")
                })
        }
    }
}
</script>

<style>
</style>
