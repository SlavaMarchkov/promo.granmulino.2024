export default {
    /**
     * Возвращает массив с записями
     *
     * @param state
     * @returns {Array}
     */
    getCustomers: (state) => state.customers,

    /**
     * Возвращает одну запись по ID
     *
     * @returns {function(*): Object}
     */
    oneCustomer: (state) => id => state.customers
        .find(item => item.id === id),
};
