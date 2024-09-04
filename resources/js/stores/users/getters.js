export default {
    /**
     * Возвращает массив с записями
     *
     * @param state
     * @returns {Array}
     */
    getUsers: (state) => state.users,

    /**
     * Возвращает одну запись по ID
     *
     * @returns {function(*): Object}
     */
    oneUser: (state) => id => state.users
        .find(item => item.id === id),
};
