<template>
    <div>
        <div v-if="signedIn && ! locked">
            <div class="form-group">
                <textarea id="body"
                          v-model="data"
                          name="body"
                          cols="30"
                          rows="5"
                          class="form-control"
                          required
                          placeholder="Have something to say?"
                ></textarea>
            </div>
            <button class="btn btn-default"
                    type="submit"
                    @click="addReply"
            >
                POST
            </button>
        </div>
        <p v-else-if="locked" class="text-center text-danger">
            The thread is locked. You could not post anymore.
        </p>
        <p v-else class="text-center">
            Please
            <a href="/login">sign in</a>
            to participate in this dicussion.
        </p>
    </div>
</template>

<script>
import "jquery.caret"
import "at.js"

export default {
    name: "NewReply",

    props: ["locked"],

    data () {
        return {
            data: ""
        }
    },

    computed: {
        endpoint () {
            return location.pathname + "/replies"
        }
    },

    mounted () {
        $("#body").atwho({
            at: "@",
            delay: 400,
            callbacks: {
                remoteFilter: function (query, callback) {
                    $.getJSON("/api/users", { name: query }, function (usernames) {
                        callback(usernames)
                    })
                }
            }
        })
    },

    methods: {
        addReply () {
            axios.post(this.endpoint, {
                body: this.data
            })
                .then(response => {
                    this.data = ""

                    flash("Your reply has been posted.")

                    this.$emit("created", response.data)
                })
                .catch(({ response }) => {
                    flash(response.data, "danger")
                })
        }
    }

}
</script>

<style>
</style>
