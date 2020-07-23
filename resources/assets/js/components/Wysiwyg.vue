<template>
    <div>
        <input id="trix"
               ref="input"
               type="hidden"
               :value="value"
               :name="name"
        >

        <trix-editor ref="trix"
                     input="trix"
                     :placeholder="placeholder"
                     @trix-change="change"
        ></trix-editor>
    </div>
</template>

<script>
import Trix from "trix"

export default {
    name: "Wysiwyg",

    props: [
        "name",
        "init",
        "value",
        "placeholder"
    ],

    data () {
        return {
            //
        }
    },

    watch: {
        value (value) {
            if (value.length === 0) {
                this.$refs.trix.value = ""
            }
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
