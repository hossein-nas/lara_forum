
require("./bootstrap")

Vue.component("flash", require("./components/Flash.vue").default)

// pages
Vue.component("thread-view", require("./pages/Thread.vue").default)

const app = new Vue({
    el: "#app"
})
