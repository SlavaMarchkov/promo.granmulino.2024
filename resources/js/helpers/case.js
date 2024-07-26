export const toCamelCase = (str) => {
    return str.replace(/_([a-z])/g, (g) => g[1].toUpperCase());
};

export const toSnakeCase = (str) => {
    return str.replace(/([a-zA-Z])(?=[A-Z])/g, '$1_').toLowerCase();
};

export const convertCase = (obj, func) => {
    const newObj = {};
    for ( const key in obj ) {
        if ( obj.hasOwnProperty(key) ) {
            const value = obj[key];
            const keyConverted = func(key);
            const isRecursive = typeof value === 'object';
            newObj[keyConverted] = isRecursive ? convertCase(value, func) : value;
        }
    }
    return newObj;
};
