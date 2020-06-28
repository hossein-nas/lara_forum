
window.$ = window.jQuery = require("jquery")
require("bootstrap-sass")

window.Vue = require("vue")

Vue.prototype.authorize = function (handler) {
    const user = window.App.user

    return user ? handler(user) : false
}

window.axios = require("axios")
window.axios.defaults.headers.common = {
    "X-CSRF-TOKEN": window.App.csrfToken,
    "X-Requested-With": "XMLHttpRequest"
}

window.events = new Vue()
window.flash = (message, level = "success") => {
    window.events.$emit("flash", { message, level })
}
