<template>
    <div v-show="show" class="alert alert-success">
        <strong>Success !</strong> {{ body }}
    </div>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            required: true
        }
    },
    data () {
        return {
            body: "",
            show: false
        }
    },

    created () {
        if (this.message) this.flash(this.message)

        window.events.$on("flash", (message) => {
            this.flash(message)
        })
    },

    methods: {
        flash (message) {
            this.body = message
            this.show = true

            this.hide()
        },

        hide () {
            setTimeout(() => {
                this.show = false
            }, 3000)
        }
    }
}
</script>

<style>
.alert{
    position: fixed;
    bottom: 25px;
    right: 25px;
}
</style>
