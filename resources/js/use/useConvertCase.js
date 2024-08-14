import { ref } from 'vue';

export function useConvertCase() {
    let str = ref('');

    const toCamel = () => {
        str = str.replace(/_([a-z])/g, (g) => g[1].toUpperCase());
    };

    const toSnake = () => {
        str = str.replace(/([a-zA-Z])(?=[A-Z])/g, '$1_').toLowerCase();
    };

    const makeConvertibleObject = (obj, func) => {
        const newObj = {};
        for ( const key in obj ) {
            if ( obj.hasOwnProperty(key) ) {
                const value = obj[key];
                const keyConverted = func(key);
                const isRecursive = typeof value === 'object';
                newObj[keyConverted] = isRecursive ? makeConvertibleObject(value, func) : value;
            }
        }
        return newObj;
    };

    return {
        toCamel,
        toSnake,
        makeConvertibleObject,
    };
}
