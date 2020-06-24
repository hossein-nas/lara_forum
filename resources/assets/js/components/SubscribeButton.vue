<template>
    <button :class="classes"
            style="margin-top: 1.5rem"
            @click="subscribe"
            v-text="buttonText"
    >
    </button>
</template>

<script>

export default {
    name: "SubscribeButton",

    props: ["active"],

    data () {
        return {
            activeState: this.active
        }
    },

    computed: {
        endpoint () {
            return location.pathname + "/subscriptions"
        },

        buttonText () {
            return this.activeState ? "Subscribed" : "Subscribe"
        },

        classes () {
            return ["btn", this.activeState ? "btn-primary" : "btn-default"]
        },

        actionType () {
            return this.activeState ? "delete" : "post"
        }
    },

    methods: {
        subscribe () {
            axios[this.actionType](this.endpoint)
                .then(this.subscribed)
        },

        subscribed ({ data }) {
            this.activeState = !this.activeState

            if (this.actionType == "post") {
                flash("Subscribed")
            } else {
                flash("Unsubscribed")
            }
        }
    }

}
</script>

<style>
</style>
