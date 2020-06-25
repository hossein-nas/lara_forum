<template>
    <li v-if="notifications.length" class="dropdown">
        <a href="#"
           class="dropdown-toggle"
           data-toggle="dropdown"
        >
            <span class="glyphicon glyphicon-bell"></span>
        </a>

        <ul class="dropdown-menu">
            <li v-for="notification in notifications" :key="notification.id">
                <a :href="notification.data.link"
                   @click="markAsRead(notification)"
                   v-text="notification.data.message"
                ></a>
            </li>
        </ul>
    </li>
</template>

<script>

export default {
    name: "UserNotifications",

    data () {
        return {
            notifications: []
        }
    },

    computed: {
        endpoint () {
            return `/profiles/${window.App.user.anem}/notifications`
        }
    },

    created () {
        this.fetched()
    },

    methods: {
        fetched () {
            axios.get(this.endpoint)
                .then(({ data }) => {
                    this.notifications = data
                })
        },

        markAsRead (notification) {
            axios.delete(`/profiles/${window.App.user.name}/notifications/${notification.id}`)
                .then(({ data }) => {

                })
        }
    }
}
</script>

<style>
</style>
