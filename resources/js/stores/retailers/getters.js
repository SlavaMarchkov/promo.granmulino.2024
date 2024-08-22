export default {
    /**
     * Возвращает массив с записями
     *
     * @param state
     * @returns {Array}
     */
    getRetailers: (state) => state.retailers,

    /**
     * Возвращает одну запись по ID
     *
     * @returns {function(*): Object}
     */
    oneRetailer: (state) => id => state.retailers
        .find(item => item.id === id),
};
