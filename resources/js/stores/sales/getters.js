export default {
    /**
     * Возвращает массив с планом продаж
     *
     * @param state
     * @returns {Array}
     */
    getSales: state => state.sales,

    /**
     * Возвращает массив с группами товаров
     *
     * @param state
     * @returns {Array}
     */
    getCategories: state => state.categories,
};
