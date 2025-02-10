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

    /**
     * Возвращает массив с годами из поля start_date промо-акций
     *
     * @param state
     * @returns {Array}
     */
    getYears: state => state.years,
};
