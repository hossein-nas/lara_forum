<template>
    <div>
        <div class="level">
            <img v-if="avatar"
                 :src="avatar"
                 alt=""
                 width="80"
                 class="mr-1"
            >
            <div>
                <h2>
                    {{ user.name }} <br>
                </h2>
                Since {{ ago }}
            </div>
        </div>

        <form v-if="canUpdate"
              method="POST"
              enctype="multipart/form-data"
        >
            <image-upload @loaded="onLoad"></image-upload>
        </form>
    </div>
</template>

<script>
import moment from "moment"
import ImageUpload from "./ImageUpload.vue"

export default {
    name: "AvatarForm",

    components: {
        ImageUpload
    },

    props: ["user"],

    data () {
        return {
            avatar: ""
        }
    },

    computed: {
        canUpdate () {
            return this.authorize((user) => user.id === this.user.id)
        },

        ago () {
            return moment(this.user.created_at).fromNow()
        }
    },

    mounted () {
        if (this.user.avatar_path) {
            this.avatar = this.user.avatar_path
        }
    },

    methods: {
        onLoad (payload) {
            this.avatar = payload.src
            this.persist(payload.file)
        },

        persist (avatar) {
            let data = new FormData()

            data.append("avatar", avatar)

            axios.post(`/api/users/${this.user.name}/avatar`, data)
                .then((res) => {
                    flash("Avatar Uploaded.")
                })
        }
    }
}
</script>

<style>
</style>
