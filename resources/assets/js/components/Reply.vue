<script>
import Favorite from "./Favorite"

export default {
    name: "Reply",

    components: {
        Favorite
    },

    props: {
        attributes: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            editing: false,
            body: this.attributes.body
        }
    },

    methods: {
        submitUpdate () {
            axios.patch("/replies/" + this.attributes.id, {
                body: this.body
            })
                .then(() => {
                    this.postSubmit()
                })
        },

        postSubmit () {
            this.editing = false
            flash("Your Reply has been updated")
        },

        destroy () {
            axios.delete("/replies/" + this.attributes.id)
                .then(() => {
                    $(this.$el).fadeOut(300,
                        () => flash("Your reply has been deleted.")
                    )
                })
        }
    }

}
</script>

<style>

</style>
