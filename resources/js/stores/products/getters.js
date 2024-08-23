export default {
    /**
     * Возвращает массив с записями
     *
     * @param state
     * @returns {Array}
     */
    getProducts: (state) => state.products,

    /**
     * Возвращает одну запись по ID
     *
     * @returns {function(*): Object}
     */
    oneProduct: (state) => id => state.products
        .find(item => item.id === id),
};
