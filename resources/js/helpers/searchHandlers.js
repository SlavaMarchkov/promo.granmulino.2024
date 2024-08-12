export const resetSearchKeys = (obj) => {
    for ( const key in obj ) {
        obj[key] = (key === 'isActive') ? false : '';
    }
};
