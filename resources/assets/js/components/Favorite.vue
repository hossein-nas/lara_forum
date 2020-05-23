<template>
    <button type="submit"
            :class="classes"
            @click="toggle"
    >
        <span class="glyphicon glyphicon-heart" />
        {{ favoritesCount }} {{ label }}
    </button>
</template>

<script>
export default {
    name: "Favorite",
    props: {
        reply: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            data: this.reply,
            favoritesCount: this.reply.favorites_count,
            isFavorited: this.reply.favorited_by_me
        }
    },

    computed: {
        label () {
            if (this.favoritesCount === 0 || this.favoritesCount > 1) {
                return "Favorites"
            }
            return "Favorite"
        },

        classes () {
            return ["btn", this.isFavorited ? "btn-primary" : "btn-default"]
        },

        endpoint () {
            return `/replies/${this.reply.id}/favorites`
        }
    },

    methods: {
        toggle () {
            if (this.isFavorited) {
                this.unfavorite()
            } else {
                this.favorite()
            }
        },

        favorite () {
            axios.post(this.endpoint)
                .then(() => {
                    this.favoritesCount++
                    this.isFavorited = true
                })
        },

        unfavorite () {
            axios.delete(this.endpoint)
                .then(() => {
                    this.favoritesCount--
                    this.isFavorited = false
                })
        }
    }

}
</script>

<style>
</style>
