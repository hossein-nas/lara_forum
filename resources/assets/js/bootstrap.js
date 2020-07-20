
window.$ = window.jQuery = require("jquery")
require("bootstrap-sass")

window.Vue = require("vue")

let authorizations = require("./authorizations")
Vue.prototype.authorize = function (...params) {
    let user = window.App.user
    if (!user) return false

    if (typeof params[0] === "string") {
        return authorizations[params[0]](params[1])
    }

    return params[0](user)
}
Vue.prototype.signedIn = window.App.signedIn

window.axios = require("axios")
window.axios.defaults.headers.common = {
    "X-CSRF-TOKEN": window.App.csrfToken,
    "X-Requested-With": "XMLHttpRequest"
}

window.events = new Vue()
window.flash = (message, level = "success") => {
    window.events.$emit("flash", { message, level })
}
