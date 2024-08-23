export default {
    /**
     * Возвращает массив с записями
     *
     * @param state
     * @returns {Array}
     */
    getCategories: (state) => state.categories,

    /**
     * Возвращает одну запись по ID
     *
     * @returns {function(*): Object}
     */
    oneCategory: (state) => id => state.categories
        .find(item => item.id === id),
};
