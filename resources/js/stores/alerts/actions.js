export default {
    success(message, closeable = false) {
        this.alert = {
            message,
            type: 'alert-success',
            closeable,
        };
    },

    error(message, closeable = false) {
        this.alert = {
            message,
            type: 'alert-danger',
            closeable,
        };
    },

    clear() {
        this.alert = null;
    },
};
