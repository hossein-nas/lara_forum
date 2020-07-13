<template>
    <div class="form-group">
        <label for="avatarPhoto">Select Avatar</label>
        <input id="avatar"
               accept="image/*"
               type="file"
               name="avatar"
               @change="onChange"
        >
    </div>
</template>

<script>

export default {
    name: "ImageUpload",

    data () {
        return {
            //
        }
    },

    methods: {
        onChange (e) {
            if (!e.target.files.length) return

            let file = e.target.files[0]

            let reader = new FileReader()
            reader.readAsDataURL(file)

            reader.onload = (e) => {
                this.$emit("loaded", {
                    src: e.target.result,
                    file
                })
            }
        }

    }

}
</script>

<style>
</style>
