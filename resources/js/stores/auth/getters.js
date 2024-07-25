export default {
    /**
     * Возвращает токен
     *
     * @param state
     * @returns {String}
     */
    getToken: state => state.token,

    /**
     * Возвращает объект авторизованного пользователя
     *
     * @param state
     * @returns {Object}
     */
    getUser: state => state.user,
};
