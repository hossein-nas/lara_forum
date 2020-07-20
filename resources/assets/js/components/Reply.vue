<template>
    <div :id="reply_id"
         class="panel "
         :class=" (isBest? 'panel-success' : 'panel-default') "
    >
        <div class="panel-heading">
            <div class="level">
                <span class="flex">
                    <a :href="'/profiles/' + data.owner.name" v-text="data.owner.name">
                    </a> said <span v-text="ago"></span> ...
                </span>

                <div>
                    <favorite v-if="signedIn" :reply="data"></favorite>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div v-if="editing">
                <form @submit.prevent="submitUpdate">
                    <div class="form-group">
                        <textarea id="reply-body"
                                  v-model="body"
                                  required
                                  class="form-control"
                                  name="reply-body"
                        > </textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-xs" type="submit">
                            Update
                        </button>
                        <button type="button"
                                class="btn btn-link btn-xs"
                                @click="editing = false"
                        >
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
            <div v-else v-html="body">
            </div>
        </div>

        <div v-if="!editing" class="panel-footer level">
            <div v-if="canUpdate">
                <button class="btn btn-xs mr-1" @click="editing = !editing ">
                    Edit
                </button>
                <button class="btn btn-danger btn-xs mr-1" @click="destroy">
                    Delete
                </button>
            </div>

            <button v-if="! isBest"
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
        attributes: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            data: this.attributes,
            editing: false,
            body: this.attributes.body,
            isBest: false
        }
    },

    computed: {
        ago () {
            return moment(this.data.created_at).fromNow()
        },

        reply_id () {
            return ["reply-no-", this.data.id].join("")
        },

        signedIn () {
            return window.App.signedIn
        },

        canUpdate () {
            return this.authorize(user => this.data.user_id === user.id)
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
                .catch(error => {
                    flash(error.response.data, "danger")
                })
        },

        postSubmit () {
            this.editing = false
            flash("Your Reply has been updated")
        },

        destroy () {
            axios.delete("/replies/" + this.attributes.id)
                .then(() => {
                    this.$emit("deleted", this.data.id)
                })
        },

        markBestReply () {
            this.isBest = true
        }
    }

}
</script>

<style>

</style>
