export default {
    /**
     * Возвращает массив с записями
     *
     * @param state
     * @returns {Array}
     */
    getRegions: (state) => state.regions,

    /**
     * Возвращает одну запись по ID
     *
     * @returns {function(*): Object}
     */
    oneRegion: (state) => id => state.regions
        .find(item => item.id === id),
};
