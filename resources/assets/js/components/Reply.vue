<template>
    <div :id="reply_id" class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <span class="flex">
                    <a :href="'/profiles/' + data.owner.name" v-text="data.owner.name">
                    </a> said {{ data.created_at }}...
                </span>

                <div>
                    <favorite v-if="signedIn" :reply="data"></favorite>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea id="reply-body"
                              v-model="body"
                              class="form-control"
                              name="reply-body"
                    > </textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-xs" @click="submitUpdate">
                        Update
                    </button>
                    <button class="btn btn-link btn-xs" @click="editing = false">
                        Cancel
                    </button>
                </div>
            </div>
            <div v-else>
                {{ body }}
            </div>
        </div>

        <div v-if="!editing && canUpdate" class="panel-footer level">
            <button class="btn btn-xs mr-1" @click="editing = !editing ">
                Edit
            </button>
            <button class="btn btn-danger btn-xs mr-1" @click="destroy">
                Delete
            </button>
        </div>
    </div>
</template>
<script>
import Favorite from "./Favorite"

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
            body: this.attributes.body
        }
    },

    computed: {
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
        },

        postSubmit () {
            this.editing = false
            // flash("Your Reply has been updated")
        },

        destroy () {
            axios.delete("/replies/" + this.attributes.id)
                .then(() => {
                    this.$emit("deleted", this.data.id)
                })
        }
    }

}
</script>

<style>

</style>
