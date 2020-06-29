<template>
    <div v-show="show"
         class="alert alert-flash"
         :class="'alert-' + level"
    >
        <strong>{{ firstMessage }}!</strong> {{ body }}
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
            level: "success",
            show: false
        }
    },

    computed: {
        firstMessage () {
            return this.level.charAt(0).toUpperCase() + this.level.slice(1)
        }
    },

    created () {
        if (this.message) this.flash(this.message)

        window.events.$on("flash", (data) => {
            this.flash(data)
        })
    },

    methods: {
        flash (data) {
            this.body = data.message
            this.level = data.level
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
.alert-flash{
    position: fixed;
    bottom: 25px;
    right: 25px;
}
</style>
