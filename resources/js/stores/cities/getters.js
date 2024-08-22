export default {
    /**
     * Возвращает массив с записями
     *
     * @param state
     * @returns {Array}
     */
    getCities: (state) => state.cities,

    /**
     * Возвращает одну запись по ID
     *
     * @returns {function(*): Object}
     */
    oneCity: (state) => id => state.cities
        .find(item => item.id === id),
};
