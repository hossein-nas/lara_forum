let user = window.App.user

module.exports = {
    updateReply (reply) {
        return user.id === reply.user_id
    }
}
