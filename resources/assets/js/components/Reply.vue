<template>
    <div :id="reply_id"
         class="panel "
         :class=" (isBest? 'panel-success' : 'panel-default') "
    >
        <div class="panel-heading">
            <div class="level">
                <span class="flex">
                    <a :href="'/profiles/' + reply.owner.name" v-text="reply.owner.name">
                    </a> said <span v-text="ago"></span> ...
                </span>

                <div>
                    <favorite v-if="signedIn" :reply="reply"></favorite>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div v-if="editing">
                <form @submit.prevent="submitUpdate">
                    <div class="form-group">
                        <wysiwyg v-model="body"></wysiwyg>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-xs" type="submit">
                            Update
                        </button>
                        <button type="button"
                                class="btn btn-link btn-xs"
                                @click="cancel"
                        >
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
            <div v-else v-html="body">
            </div>
        </div>

        <div v-if="!editing && ( authorize('owns', reply) || authorize('owns', reply.thread) )" class="panel-footer level">
            <div v-if="authorize('owns', reply)">
                <button class="btn btn-xs mr-1" @click="editing = !editing ">
                    Edit
                </button>
                <button class="btn btn-danger btn-xs mr-1" @click="destroy">
                    Delete
                </button>
            </div>

            <button v-if="authorize('owns', reply.thread)"
                    v-show="! isBest"
                    class="btn btn-default btn-xs ml-a"
                    @click="markBestReply"
            >
                Best Reply?
            </button>
        </div>
    </div>
</template>
<script>
import Favorite from "./Favorite"
import moment from "moment"

export default {
    name: "Reply",

    components: {
        Favorite
    },

    props: {
        reply: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            id: this.reply.id,
            editing: false,
            old: "",
            body: this.reply.body,
            isBest: this.reply.isBest
        }
    },

    computed: {
        ago () {
            return moment(this.reply.created_at).fromNow()
        },

        reply_id () {
            return ["reply-no-", this.id].join("")
        }
    },

    watch: {
        editing () {
            this.old = this.body
        }
    },

    created () {
        window.events.$on("best-reply-selected", (reply_id) => {
            console.log("here")
            this.isBest = (this.id === reply_id)
        })
    },

    methods: {
        submitUpdate () {
            axios.patch("/replies/" + this.id, {
                body: this.body
            })
                .then(() => {
                    this.postSubmit()
                })
                .catch(error => {
                    flash(error.response.data, "danger")
                })
        },

        postSubmit () {
            this.editing = false
            flash("Your Reply has been updated")
        },

        destroy () {
            axios.delete("/replies/" + this.id)
                .then(() => {
                    this.$emit("deleted", this.id)
                })
        },

        markBestReply () {
            axios.post(`/replies/${this.id}/best`)
                .then(() => {
                    window.events.$emit("best-reply-selected", this.id)

                    flash("Selected best reply successfully", "success")
                })
        },

        cancel () {
            this.body = this.old

            this.editing = false
        }
    }

}
</script>

<style>

</style>
