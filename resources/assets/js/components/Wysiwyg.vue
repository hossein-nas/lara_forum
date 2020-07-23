<template>
    <div>
        <input id="trix"
               ref="input"
               type="hidden"
               :value="value"
               :name="name"
        >

        <trix-editor input="trix" @trix-change="change"></trix-editor>
    </div>
</template>

<script>
import Trix from "trix"

export default {
    name: "Wysiwyg",

    props: ["name", "init", "value"],

    data () {
        return {
            //
        }
    },

    mounted () {
        if (!!this.init) {
            this.$refs.input.value = JSON.parse(this.init)
        }
    },

    methods: {
        change () {
            let value = this.$refs.input.value
            this.$emit("input", value)
        }

    }
}
</script>

<style>
@import "~trix/dist/trix.css";
</style>
