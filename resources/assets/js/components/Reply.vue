<script>
export default {
    name: "Reply",

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
        }

    }

}
</script>

<style>

</style>
